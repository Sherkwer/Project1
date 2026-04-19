document.addEventListener('DOMContentLoaded', function () {

    const fileInput = document.getElementById('student_csv');
    const previewContainer = document.getElementById('studentPreviewContainer');
    const validationSection = document.getElementById('studentValidationSection');
    const validatedContainer = document.getElementById('validatedStudentContainer');
    const rowCountBadge = document.getElementById('studentRowCountBadge');
    const validatedCountBadge = document.getElementById('studentValidatedCountBadge');
    const clearBtn = document.getElementById('clearStudentImportBtn');
    const importBtn = document.getElementById('importStudentBtn');

    // Find the import form (it shares the same ID as the modal, so use selector to avoid ambiguity)
    const importForm = document.querySelector('form[action*="students/import"]');

    const REQUIRED_HEADERS = [
        'id','rid','sid','lname','fname','mname','fullname','email',
        'area_code','college_code','course_code','year_level',
        'term','sy','cy','password','student_status','enroll_status'
    ];

    function resetModal() {
        if (fileInput) fileInput.value = '';
        if (previewContainer) previewContainer.innerHTML = '';
        if (validationSection) validationSection.style.display = 'none';
        if (validatedContainer) validatedContainer.innerHTML = '';
        if (rowCountBadge) rowCountBadge.textContent = 'Rows: 0';
        if (validatedCountBadge) validatedCountBadge.textContent = 'Valid: 0';
        if (importBtn) importBtn.disabled = true;
    }

    function determineDelimiter(sampleLine) {
        const commaCount = (sampleLine.match(/,/g) || []).length;
        const tabCount = (sampleLine.match(/\t/g) || []).length;
        return tabCount > commaCount ? '\t' : ',';
    }

    function parseCsvLine(line, delimiter = ',') {
        const cells = [];
        let current = '';
        let inQuotes = false;

        for (let i = 0; i < line.length; i++) {
            const char = line[i];
            const nextChar = line[i + 1];

            if (char === '"') {
                if (inQuotes && nextChar === '"') {
                    current += '"';
                    i++;
                } else {
                    inQuotes = !inQuotes;
                }
                continue;
            }

            if (char === delimiter && !inQuotes) {
                cells.push(current);
                current = '';
                continue;
            }

            current += char;
        }

        cells.push(current);
        return cells;
    }

    function validateHeaders(headers) {
        // Allow extra headers, just require that all required headers exist
        return REQUIRED_HEADERS.every(required => headers.includes(required));
    }

    function getMissingHeaders(headers) {
        return REQUIRED_HEADERS.filter(required => !headers.includes(required));
    }

    function setValidationMessage(message, type = 'warning') {
        const alert = document.createElement('div');
        alert.classList.add('alert', `alert-${type}`, 'py-2', 'mb-2');
        alert.textContent = message;
        validatedContainer.insertBefore(alert, validatedContainer.firstChild);
    }

    function renderValidatedTable(headers, rows, invalidRows) {
        const table = document.createElement('table');
        table.classList.add('table', 'table-bordered', 'table-striped', 'table-sm');

        const thead = document.createElement('thead');
        const headerRow = document.createElement('tr');
        headers.forEach(h => {
            const th = document.createElement('th');
            th.textContent = h;
            headerRow.appendChild(th);
        });

        // Add status column
        const statusTh = document.createElement('th');
        statusTh.textContent = 'Status';
        headerRow.appendChild(statusTh);

        thead.appendChild(headerRow);
        table.appendChild(thead);

        const tbody = document.createElement('tbody');
        rows.forEach((cells, index) => {
            const tr = document.createElement('tr');
            const isInvalid = invalidRows.has(index);

            cells.forEach(cell => {
                const td = document.createElement('td');
                td.textContent = cell;
                tr.appendChild(td);
            });

            const statusTd = document.createElement('td');
            statusTd.textContent = isInvalid ? 'Invalid' : 'Valid';
            statusTd.classList.add(isInvalid ? 'text-danger' : 'text-success');
            tr.appendChild(statusTd);

            if (isInvalid) {
                tr.classList.add('table-warning');
            }

            tbody.appendChild(tr);
        });
        table.appendChild(tbody);

        const responsive = document.createElement('div');
        responsive.classList.add('table-responsive');
        responsive.appendChild(table);

        validatedContainer.innerHTML = '';
        validatedContainer.appendChild(responsive);
    }

    function showError(message) {
        alert(message);
        resetModal();
    }

    function handleFile(file) {
        if (!file) {
            resetModal();
            return;
        }

        if (!file.name.toLowerCase().endsWith('.csv')) {
            showError('Invalid file type. Please upload a .csv file.');
            return;
        }

        if (file.size > 2 * 1024 * 1024) {
            showError('File too large. Maximum allowed size is 2 MB.');
            return;
        }

        const reader = new FileReader();
        reader.onload = function (event) {
            const text = event.target.result || '';
            const lines = text.split(/\r?\n/).filter(line => line.trim() !== '');

            if (lines.length < 2) {
                showError('CSV must contain a header row and at least one data row.');
                return;
            }

            const delimiter = determineDelimiter(lines[0]);
            const headerRow = parseCsvLine(lines[0], delimiter).map(h => h.trim());
            const normalizedHeaders = headerRow.map(h => h.toLowerCase());

            const missingHeaders = getMissingHeaders(normalizedHeaders);
            if (missingHeaders.length > 0) {
                setValidationMessage('Missing required columns: ' + missingHeaders.join(', '), 'warning');
            }

            let dataRows = lines.slice(1).map(line => parseCsvLine(line, delimiter));

            // Normalize \N to empty string (so it doesn’t count as missing)
            dataRows = dataRows.map(row => row.map(cell => {
                const trimmed = (cell || '').trim();
                return trimmed === '\\N' ? '' : trimmed;
            }));

            // Identify invalid rows (missing required fields or wrong column count)
            const invalidRows = new Set();
            dataRows.forEach((rawCells, index) => {
                const cells = [...rawCells];

                // Normalize trailing empty cells (common when file ends with a separator)
                while (cells.length > headerRow.length && cells[cells.length - 1].trim() === '') {
                    cells.pop();
                }

                // column count mismatch
                if (cells.length !== headerRow.length) {
                    invalidRows.add(index);
                    return;
                }

                // Removed validation for missing required fields to make it flexible
            });

            renderValidatedTable(headerRow, dataRows, invalidRows);

            const validCount = dataRows.length - invalidRows.size;

            if (rowCountBadge) rowCountBadge.textContent = 'Rows: ' + dataRows.length;
            if (validatedCountBadge) validatedCountBadge.textContent = 'Valid: ' + validCount;
            if (validationSection) validationSection.style.display = 'block';
            if (importBtn) importBtn.disabled = (validCount === 0);
        };

        reader.onerror = function () {
            showError('Unable to read the selected file. Please try again.');
        };

        reader.readAsText(file);
    }

    if (fileInput) {
        fileInput.addEventListener('change', function (e) {
            handleFile(e.target.files[0]);
        });
    }

    if (clearBtn) {
        clearBtn.addEventListener('click', function () {
            resetModal();
        });
    }

    if (importBtn && importForm) {
        importBtn.addEventListener('click', function () {
            if (!fileInput || !fileInput.files || fileInput.files.length === 0) {
                alert('Please select a valid CSV file before importing.');
                return;
            }

            if (!confirm('Are you sure you want to import these students? This will create or update student records.')) {
                return;
            }

            importForm.submit();
        });
    }

    // Reset when modal closes (Bootstrap)
    $('#importStudentModal').on('hidden.bs.modal', function () {
        resetModal();
    });

    // Initial state
    resetModal();
});
