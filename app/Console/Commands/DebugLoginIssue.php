<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class DebugLoginIssue extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'debug:login-issue
                            {--email=developerdev631@gmail.com : The email address to check}
                            {--password=12345678 : The plain-text password to verify}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Diagnose login failures by checking user existence, password hash compatibility, and generating a corrected hash if needed.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $targetEmail = $this->option('email');
        $plainPassword = $this->option('password');

        $this->newLine();
        $this->line('╔══════════════════════════════════════════════════════════╗');
        $this->line('║              LOGIN ISSUE DEBUGGER                       ║');
        $this->line('╚══════════════════════════════════════════════════════════╝');
        $this->newLine();

        // ── 1. Database connectivity ──────────────────────────────────────────
        $this->info('[ 1 ] Checking database connection...');
        try {
            DB::connection()->getPdo();
            $this->line('      ✔  Connected to database: ' . DB::connection()->getDatabaseName());
        } catch (\Throwable $e) {
            $this->error('      ✘  Database connection failed: ' . $e->getMessage());
            return self::FAILURE;
        }
        $this->newLine();

        // ── 2. Total user count ───────────────────────────────────────────────
        $totalUsers = User::withTrashed()->count();
        $this->info("[ 2 ] Total users in database (including soft-deleted): {$totalUsers}");
        $this->newLine();

        // ── 3. Look up the target user ────────────────────────────────────────
        $this->info("[ 3 ] Looking up user: {$targetEmail}");

        // Exact match first
        $user = User::withTrashed()->where('email', $targetEmail)->first();

        // Case-insensitive fallback
        if (! $user) {
            $user = User::withTrashed()
                ->whereRaw('LOWER(email) = ?', [strtolower($targetEmail)])
                ->first();
        }

        if (! $user) {
            $this->warn('      ✘  User NOT found in the database.');
            $this->newLine();

            // ── 3a. List all users to help spot the real email ────────────────
            $this->info('[ 3a ] All users currently in the database:');
            $allUsers = User::withTrashed()
                ->select('id', 'email', 'fname', 'lname', 'user_role', 'is_approved', 'deleted_at')
                ->get();

            if ($allUsers->isEmpty()) {
                $this->warn('       (no users found at all)');
            } else {
                $rows = $allUsers->map(fn ($u) => [
                    $u->id,
                    $u->email,
                    trim("{$u->fname} {$u->lname}"),
                    $u->user_role,
                    $u->is_approved,
                    $u->deleted_at ? 'SOFT-DELETED' : 'active',
                ])->toArray();

                $this->table(
                    ['ID', 'Email', 'Name', 'Role', 'Approved', 'Status'],
                    $rows
                );
            }

            $this->newLine();

            // ── 3b. Provide INSERT SQL to create the user ─────────────────────
            $correctHash = Hash::make($plainPassword);
            $this->info('[ 3b ] SQL to INSERT the missing user (adjust role/org as needed):');
            $this->line("       INSERT INTO users");
            $this->line("           (fname, lname, fullname, email, password, user_role, is_approved, email_verified_at, created_at, updated_at)");
            $this->line("       VALUES");
            $this->line("           ('Developer', 'Dev', 'Developer Dev', '{$targetEmail}', '{$correctHash}', 1, 1, NOW(), NOW(), NOW());");
            $this->newLine();

            return self::SUCCESS;
        }

        // ── 4. User found — display details ───────────────────────────────────
        $this->line('      ✔  User found!');
        $this->newLine();
        $this->info('[ 4 ] User record details:');
        $this->table(
            ['Field', 'Value'],
            [
                ['ID',              $user->id],
                ['Email (DB)',       $user->email],
                ['Email (searched)', $targetEmail],
                ['Emails match',     ($user->email === $targetEmail) ? 'YES (exact)' : 'NO — casing/whitespace differs'],
                ['Name',            trim("{$user->fname} {$user->lname}")],
                ['Role',            $user->user_role],
                ['Is Approved',     $user->is_approved],
                ['Email Verified',  $user->email_verified_at ?? 'NULL (not verified)'],
                ['Soft Deleted',    $user->deleted_at ? "YES — {$user->deleted_at}" : 'No'],
                ['Password Hash',   $user->password],
            ]
        );
        $this->newLine();

        // ── 5. Soft-delete check ──────────────────────────────────────────────
        if ($user->deleted_at) {
            $this->warn('[ 5 ] ⚠  This user is SOFT-DELETED. Auth::attempt() will not find them.');
            $this->line("       SQL to restore: UPDATE users SET deleted_at = NULL WHERE id = {$user->id};");
            $this->newLine();
        }

        // ── 6. Password hash analysis ─────────────────────────────────────────
        $this->info('[ 6 ] Password hash analysis:');
        $storedHash = $user->password;

        if (empty($storedHash)) {
            $this->error('      ✘  Password field is NULL or empty — no hash stored.');
        } else {
            $prefix = substr($storedHash, 0, 4);
            $this->line("      Hash prefix : {$prefix}");

            if ($prefix === '$2y$') {
                $this->line('      Hash type   : PHP-native bcrypt ($2y$) — compatible ✔');
            } elseif ($prefix === '$2a$' || substr($storedHash, 0, 4) === '$2b$') {
                $this->warn("      Hash type   : {$prefix} bcrypt — NOT the PHP-native \$2y\$ variant.");
                $this->warn('      Laravel\'s Hash::check() uses $2y$. This is the most likely cause of login failure.');
            } else {
                $this->warn("      Hash type   : Unknown / unsupported ({$prefix})");
            }
        }
        $this->newLine();

        // ── 7. Direct password verification ───────────────────────────────────
        $this->info("[ 7 ] Verifying password '{$plainPassword}' against stored hash...");

        $hashCheckResult = ! empty($storedHash) && Hash::check($plainPassword, $storedHash);

        if ($hashCheckResult) {
            $this->line('      ✔  Hash::check() PASSED — password matches the stored hash.');
            $this->line('         If login still fails, check email casing, soft-delete status, or email_verified_at.');
        } else {
            $this->error('      ✘  Hash::check() FAILED — password does NOT match the stored hash.');
        }
        $this->newLine();

        // ── 8. Generate a correct $2y$ hash and provide fix SQL ───────────────
        $this->info('[ 8 ] Generating a fresh $2y$ bcrypt hash for the given password...');
        $correctHash = Hash::make($plainPassword);
        $this->line("      New hash : {$correctHash}");
        $this->newLine();

        $this->info('[ 9 ] SQL command to update the password to the correct hash:');
        $this->line("      UPDATE users SET password = '{$correctHash}' WHERE id = {$user->id};");
        $this->newLine();

        // ── 9. Summary & recommendation ───────────────────────────────────────
        $this->line('╔══════════════════════════════════════════════════════════╗');
        $this->line('║                      SUMMARY                            ║');
        $this->line('╚══════════════════════════════════════════════════════════╝');

        $issues = [];

        if ($user->deleted_at) {
            $issues[] = 'User is soft-deleted — restore with: UPDATE users SET deleted_at = NULL WHERE id = ' . $user->id . ';';
        }

        if (! $user->email_verified_at) {
            $issues[] = 'email_verified_at is NULL — mark verified with: UPDATE users SET email_verified_at = NOW() WHERE id = ' . $user->id . ';';
        }

        if (! $hashCheckResult) {
            $issues[] = "Password hash mismatch — fix with: UPDATE users SET password = '{$correctHash}' WHERE id = {$user->id};";
        }

        if ($user->email !== $targetEmail) {
            $issues[] = "Email casing/whitespace mismatch (DB: '{$user->email}' vs searched: '{$targetEmail}') — fix with: UPDATE users SET email = '{$targetEmail}' WHERE id = {$user->id};";
        }

        if (empty($issues)) {
            $this->info('  ✔  No issues detected. User exists, password matches, account is active.');
            $this->line('     If login still fails, check session/cookie configuration or middleware.');
        } else {
            $this->warn('  Issues found (' . count($issues) . '):');
            foreach ($issues as $i => $issue) {
                $this->line('  ' . ($i + 1) . '. ' . $issue);
            }
        }

        $this->newLine();

        return self::SUCCESS;
    }
}
