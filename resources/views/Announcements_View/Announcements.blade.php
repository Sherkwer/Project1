@extends('adminlte::page')
@section('title', 'Announcements')
@section('content_header')
    <h1>Announcements</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item active">Dashboard</li>
        <li class="breadcrumb-item">Announcements</li>
    </ol>
@stop
@section('content')

<div class="page-wrap">
    <div class="container">
        <!-- Header -->
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3 mb-4">
          <h1 class="page-title">Announcement Management</h1>

          <div class="d-flex align-items-center toolbar flex-wrap ms-auto">
            <div class="search-wrap position-relative">
              <i class="fa-solid fa-magnifying-glass search-icon"></i>
              <input class="form-control search-input" type="search" placeholder="Search" aria-label="Search" />
            </div>

            <button type="button" class="btn btn-primary btn-primary-soft">
              <i class="fa-regular fa-paper-plane me-2"></i>
              Post Announcement
            </button>
          </div>
        </div>

        <!-- Announcements List -->
        <div class="ui-card card-pad mb-4 fade-in" data-animate>
          <p class="section-label mb-2">Announcements List</p>

          <div class="table-responsive">
            <table class="table align-middle mb-0">
              <thead>
                <tr>
                  <th scope="col">Description</th>
                  <th scope="col">Category</th>
                  <th scope="col">Date Posted</th>
                  <th scope="col">Coverage</th>
                  <th scope="col">Status</th>
                  <th scope="col" class="text-end">Actions</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>School Sports Day Registration</td>
                  <td>Activity</td>
                  <td>Jan 15, 2024</td>
                  <td>All Students</td>
                  <td class="status-neutral">Published</td>
                  <td class="text-end actions">
                    <a href="javascript:void(0)" role="button" aria-label="Edit announcement">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="javascript:void(0)" class="action-delete" role="button" aria-label="Delete announcement">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>Midterm Examination Schedule</td>
                  <td>Briefing</td>
                  <td>Jan 14, 2024</td>
                  <td>All Students</td>
                  <td class="status-neutral">Published</td>
                  <td class="text-end actions">
                    <a href="javascript:void(0)" role="button" aria-label="Edit announcement">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="javascript:void(0)" class="action-delete" role="button" aria-label="Delete announcement">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>Lost Wallet - Grade 10 Student</td>
                  <td>Lost &amp; Found</td>
                  <td>Jan 13, 2024</td>
                  <td>All Students</td>
                  <td class="status-muted">Draft</td>
                  <td class="text-end actions">
                    <a href="javascript:void(0)" role="button" aria-label="Edit announcement">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="javascript:void(0)" class="action-delete" role="button" aria-label="Delete announcement">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
                </tr>
                <tr>
                  <td>Parent-Teacher Conference</td>
                  <td>Activity</td>
                  <td>Jan 12, 2024</td>
                  <td>All Students</td>
                  <td class="status-neutral">Published</td>
                  <td class="text-end actions">
                    <a href="javascript:void(0)" role="button" aria-label="Edit announcement">
                      <i class="fa-solid fa-pen"></i>
                    </a>
                    <a href="javascript:void(0)" class="action-delete" role="button" aria-label="Delete announcement">
                      <i class="fa-solid fa-trash"></i>
                    </a>
                  </td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>

        <!-- Recent Announcements -->
        <div class="ui-card fade-in" data-animate>
          <div class="recent-header">
            <div class="recent-icon" aria-hidden="true">
              <i class="fa-regular fa-clock"></i>
            </div>
            <div>
              <p class="recent-title">Recent Announcements</p>
              <p class="recent-sub">View previously sent announcement</p>
            </div>
          </div>

          <div class="pb-2">
            <!-- Card 1 -->
            <div class="announce-item fade-in" data-animate>
              <div class="announce-badge badge-blue" aria-hidden="true">
                <i class="fa-solid fa-clipboard-check"></i>
              </div>

              <div class="announce-main">
                <p class="announce-title">Attendance</p>
                <p class="announce-msg">Reminder: Please ensure regular attendance to avoid penalties.</p>
                <div class="announce-meta">
                  <i class="fa-regular fa-user"></i>
                  <span>Sent to: All Students (245)</span>
                </div>
              </div>

              <div class="announce-right">
                <div class="announce-time">2 hours ago</div>
                <div class="announce-status">Delivered</div>
              </div>
            </div>

            <!-- Card 2 -->
            <div class="announce-item fade-in" data-animate>
              <div class="announce-badge badge-green" aria-hidden="true">
                <i class="fa-solid fa-money-bill-wave"></i>
              </div>

              <div class="announce-main">
                <p class="announce-title">Payment</p>
                <p class="announce-msg">Payment deadline approaching. Please settle outstanding fees by March 31st.</p>
                <div class="announce-meta">
                  <i class="fa-regular fa-user"></i>
                  <span>Sent to: Selected Students (42)</span>
                </div>
              </div>

              <div class="announce-right">
                <div class="announce-time">1 day ago</div>
                <div class="announce-status">Delivered</div>
              </div>
            </div>
          </div>
      </div>
  </div>

@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}

    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap"
      rel="stylesheet"
    />

    <!-- Icons -->
    <link
      rel="stylesheet"
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
      referrerpolicy="no-referrer"
    />

    <style>
        :root{
          --bg: #f8f9fa;
          --card: #ffffff;
          --text: #111827;
          --muted: #6b7280;
          --primary: #3b82f6;
          --shadow: 0 10px 24px rgba(17, 24, 39, 0.06);
          --shadow-sm: 0 6px 16px rgba(17, 24, 39, 0.06);
          --radius: 12px;
        }

        html, body { height: 100%; }
        body{
          font-family: Inter, system-ui, -apple-system, Segoe UI, Roboto, Arial, sans-serif;
          background: var(--bg);
          color: var(--text);
        }

        .page-wrap{
          padding: 22px 0 48px;
        }

        .page-title{
          font-size: clamp(26px, 2.2vw, 32px);
          font-weight: 800;
          letter-spacing: -0.02em;
          margin: 0;
        }

        .toolbar{
          gap: 14px;
        }

        .search-wrap{
          width: min(540px, 100%);
        }

        .search-input{
          background: #f1f3f5;
          border: 1px solid rgba(17, 24, 39, 0.08);
          border-radius: 12px;
          padding-left: 44px;
          height: 46px;
          box-shadow: none;
          transition: box-shadow .18s ease, border-color .18s ease, background-color .18s ease;
        }
        .search-input::placeholder{ color: #9aa1ad; }
        .search-input:focus{
          background: #ffffff;
          border-color: rgba(59,130,246,.45);
          box-shadow: 0 0 0 .25rem rgba(59,130,246,.15);
        }
        .search-icon{
          position: absolute;
          left: 14px;
          top: 50%;
          transform: translateY(-50%);
          color: #9aa1ad;
          font-size: 14px;
          pointer-events: none;
        }

        .btn-primary-soft{
          background: var(--primary);
          border-color: var(--primary);
          border-radius: 12px;
          height: 46px;
          padding: 0 16px;
          font-weight: 700;
          box-shadow: 0 10px 18px rgba(59,130,246,.20);
          transition: transform .15s ease, box-shadow .18s ease, filter .18s ease;
          white-space: nowrap;
        }
        .btn-primary-soft:hover{
          filter: brightness(.98);
          transform: translateY(-1px);
          box-shadow: 0 14px 24px rgba(59,130,246,.26);
        }
        .btn-primary-soft:active{
          transform: translateY(0);
          box-shadow: 0 10px 18px rgba(59,130,246,.18);
        }

        .ui-card{
          background: var(--card);
          border-radius: var(--radius);
          box-shadow: var(--shadow);
          border: 1px solid rgba(17, 24, 39, 0.05);
        }

        .card-pad{
          padding: 18px 18px;
        }
        @media (min-width: 992px){
          .card-pad{ padding: 20px 22px; }
        }

        .section-label{
          font-size: 13px;
          font-weight: 800;
          color: #111827;
          margin: 0 0 10px;
        }

        .table thead th{
          font-size: 12px;
          letter-spacing: .03em;
          text-transform: none;
          color: #111827;
          border-bottom-color: rgba(17,24,39,.08);
          padding-top: 12px;
          padding-bottom: 12px;
        }
        .table tbody td{
          color: #111827;
          padding-top: 12px;
          padding-bottom: 12px;
          vertical-align: middle;
        }
        .table tbody tr{
          transition: background-color .15s ease;
        }
        .table tbody tr:hover{
          background: rgba(59,130,246,.05);
        }

        .status-muted{ color: #6b7280; }
        .status-neutral{ color: #111827; }

        .actions a{
          display: inline-flex;
          align-items: center;
          justify-content: center;
          width: 34px;
          height: 34px;
          border-radius: 10px;
          color: #111827;
          text-decoration: none;
          transition: background-color .15s ease, transform .15s ease, color .15s ease;
        }
        .actions a:hover{
          background: rgba(17,24,39,.06);
          transform: translateY(-1px);
        }
        .actions a.action-delete:hover{
          background: rgba(239,68,68,.10);
          color: #b91c1c;
        }

        .recent-header{
          display: flex;
          align-items: flex-start;
          gap: 12px;
          padding: 18px 18px 10px;
        }
        @media (min-width: 992px){
          .recent-header{ padding: 20px 22px 12px; }
        }
        .recent-icon{
          width: 34px;
          height: 34px;
          border-radius: 10px;
          background: rgba(59,130,246,.10);
          color: var(--primary);
          display: grid;
          place-items: center;
          flex: 0 0 auto;
        }
        .recent-title{
          font-weight: 800;
          margin: 0;
          font-size: 18px;
          letter-spacing: -0.01em;
        }
        .recent-sub{
          margin: 2px 0 0;
          color: var(--muted);
          font-size: 13px;
        }

        .announce-item{
          display: flex;
          gap: 14px;
          align-items: flex-start;
          background: #fff;
          border: 1px solid rgba(17,24,39,.06);
          border-radius: 12px;
          padding: 14px 14px;
          margin: 0 18px 14px;
          box-shadow: var(--shadow-sm);
          transition: transform .15s ease, box-shadow .18s ease, border-color .18s ease;
        }
        @media (min-width: 992px){
          .announce-item{
            padding: 14px 16px;
            margin: 0 22px 14px;
          }
        }
        .announce-item:hover{
          transform: translateY(-1px);
          box-shadow: 0 12px 26px rgba(17, 24, 39, 0.08);
          border-color: rgba(59,130,246,.20);
        }

        .announce-badge{
          width: 36px;
          height: 36px;
          border-radius: 12px;
          display: grid;
          place-items: center;
          flex: 0 0 auto;
          font-size: 14px;
        }
        .badge-blue{
          background: rgba(59,130,246,.12);
          color: #2563eb;
        }
        .badge-green{
          background: rgba(34,197,94,.14);
          color: #16a34a;
        }

        .announce-main{
          flex: 1 1 auto;
          min-width: 0;
        }
        .announce-title{
          font-weight: 800;
          margin: 0;
          font-size: 15px;
          letter-spacing: -0.01em;
        }
        .announce-msg{
          margin: 4px 0 0;
          color: #374151;
          font-size: 13px;
          line-height: 1.45;
        }
        .announce-meta{
          margin: 6px 0 0;
          color: var(--muted);
          font-size: 12px;
          display: flex;
          align-items: center;
          gap: 6px;
        }

        .announce-right{
          text-align: right;
          flex: 0 0 auto;
          min-width: 110px;
        }
        .announce-time{
          color: var(--muted);
          font-size: 12px;
          margin: 2px 0 0;
          white-space: nowrap;
        }
        .announce-status{
          font-weight: 800;
          font-size: 13px;
          color: #111827;
          margin: 6px 0 0;
        }

        .fade-in{
          opacity: 0;
          transform: translateY(10px);
        }
        .fade-in.is-in{
          opacity: 1;
          transform: translateY(0);
          transition: opacity .35s ease, transform .35s ease;
        }
    </style>

@stop

@section('js')
<script>
    (() => {
      const els = Array.from(document.querySelectorAll("[data-animate]"));
      if (!("IntersectionObserver" in window)) {
        els.forEach((el) => el.classList.add("is-in"));
        return;
      }

      const io = new IntersectionObserver(
        (entries) => {
          entries.forEach((entry) => {
            if (entry.isIntersecting) {
              entry.target.classList.add("is-in");
              io.unobserve(entry.target);
            }
          });
        },
        { threshold: 0.12 }
      );

      els.forEach((el) => io.observe(el));
    })();
</script>

<script>

    $(document).on('click', '.delete-modal-record', function() {
            $('.modal-title').text('Remove Record');
            $('#delete_message').html('<p>Do you want to remove this record with the title <strong>' + ' - ' + $(this).data('title') + '</strong>?</p>');
           $('#da_id').val($(this).data('id'))
            $('#DeleteEventForm').modal('show');

        });

</script>
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
@stop
