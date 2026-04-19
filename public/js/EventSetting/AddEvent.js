// THIS CODE IS FOR THE DEFAULT VALUES CARD AND THE ADD EVENT MODAL
// Checkbox handling for session availability
$(function () {

    // Holds the last "saved" default fee from the right-hand card.
    let savedDefaultFee = $('#default_fee_input').val() || null;

    // When the Save button on the Default Values card is clicked,
    // update the savedDefaultFee value. This is the ONLY time it changes.
    $('#default_fee_save_btn').on('click', function (e) {
        e.preventDefault(); // prevent accidental form submits / page reloads
        const val = $('#default_fee_input').val();
        savedDefaultFee = (val !== undefined && val !== null && val !== '') ? val : null;
        console.log('Default fee saved:', savedDefaultFee);
    });

    const hiddenFields = [
        'hidden_am_in',
        'hidden_am_out',
        'hidden_pm_in',
        'hidden_pm_out'
    ];

    const formFields = [
        'e_event_name',
        'e_venue',
        'e_schedule',
        'e_sy',
        'e_term',
        'e_fee_perSession',
        'e_description'
    ];

    // Handle checkbox changes
    $(document).on('change', '.session-checkbox', function () {
        const target = $(this).data('target');
        const value = this.checked ? this.value : 'N/A';

        console.log('Checkbox changed - Target:', target, 'Value:', value);
        $('#' + target).val(value);
    });

    // Reset form when modal opens
    $('#AddEventForm').on('show.bs.modal', function () {

        // Reset checkboxes
        $('.session-checkbox').prop('checked', false);

        // Reset hidden fields
        const hiddenValues = {};
        hiddenFields.forEach(id => {
            $('#' + id).val('N/A');
            hiddenValues[id] = 'N/A';
        });

        console.log('Form reset - Hidden field values:', hiddenValues);

        // Reset other form fields
        formFields.forEach(id => $('#' + id).val(''));

        // Set fee per session only from the last SAVED default fee
        if (savedDefaultFee !== null && savedDefaultFee !== '') {
            $('#e_fee_perSession').val(savedDefaultFee);
        }

        $('#e_status').val('Active');
    });

    // Validate before submission
    $('#eventForm').on('submit', function () {

        const hiddenValues = {};
        hiddenFields.forEach(id => {
            hiddenValues[id.replace('hidden_', '')] = $('#' + id).val();
        });

        console.log('Form submitted - Hidden field values:', hiddenValues);
    });

});


//THis code is for showing record from the table to the EDIT MODAL

    $(document).on('click', '.edit-modal-record', function(e) {
    e.preventDefault();

    // Get all data from the clicked button
    var id = $(this).data('id');
    var eventName = $(this).data('event_name');
    var schedule = $(this).data('schedule');
    var sy = $(this).data('sy');
    var term = $(this).data('term');
    var venue = $(this).data('venue');
    var amIn = $(this).data('am_in');
    var amOut = $(this).data('am_out');
    var pmIn = $(this).data('pm_in');
    var pmOut = $(this).data('pm_out');
    var fee = $(this).data('fee');
    var status = $(this).data('status');
    var description = $(this).data('description');

    // Populate modal with data (use unique IDs for the EDIT form)
    $('#edit_e_id').val(id);
    $('#edit_e_event_name').val(eventName);
    $('#edit_e_schedule').val(schedule);
    $('#edit_e_sy').val(sy);
    $('#edit_e_term').val(term);
    $('#edit_e_venue').val(venue);
    $('#edit_e_fee_perSession').val(fee);
    $('#edit_status').val(status);
    $('#edit_description').val(description);

    // Handle checkboxes for session availability
    function setCheckbox(checkboxId, hiddenId, value) {
        if (value === 'A') {
            $('#' + checkboxId).prop('checked', true);
            $('#' + hiddenId).val('A');
        } else {
            $('#' + checkboxId).prop('checked', false);
            $('#' + hiddenId).val('N/A');
        }
    }

    setCheckbox('e_am_in', 'hidden-am-in', amIn);
    setCheckbox('e_am_out', 'hidden-am-out', amOut);
    setCheckbox('e_pm_in', 'hidden-pm-in', pmIn);
    setCheckbox('e_pm_out', 'hidden-pm-out', pmOut);

    // Show Modal
    $('#EditEventForm').modal('show');
});
