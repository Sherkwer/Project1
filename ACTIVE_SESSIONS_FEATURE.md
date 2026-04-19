# Active Event Sessions Feature Update

## ✓ Enhancement Details

### Added Features

1. **Event Session Data Extraction**
   - Now captures `am_in`, `am_out`, `pm_in`, `pm_out` from event table
   - Session values: 'A' = Active, 'N/A' = Inactive

2. **Active Sessions Display**
   - Event Search Results table now includes "Active Sessions" column
   - Shows badge with active sessions:
     - Green badge: Shows active sessions (AM In, AM Out, PM In, PM Out)
     - Yellow badge: Shows "No Active Sessions" if none are active

3. **Selected Event Display**
   - Shows selected event info with Active Sessions
   - Displays as blue badge for easy visibility

### Workflow

1. User searches for event
2. Search results show:
   - Event ID
   - Event Name
   - Schedule
   - **Active Sessions** (AM In, AM Out, PM In, PM Out)
   - Select button

3. User selects event
4. Selected event displays:
   - Event ID
   - Event Name
   - Schedule
   - **Active Sessions** badge

5. File input enabled
6. User uploads CSV with attendance records

### Example Display

**Event Search Results:**
| Event ID | Event Name | Schedule | Active Sessions | Action |
|----------|-----------|----------|-----------------|--------|
| EV001 | Enrollment | Morning | AM In, PM In | Select |
| EV002 | Registration | Afternoon | AM Out, PM Out | Select |

**Selected Event:**
- Event ID: EV001
- Event Name: Enrollment
- Schedule: Morning
- Active Sessions: [AM In, PM In]

### Benefits

✓ Users can see which sessions are active before selecting event
✓ Better understanding of event schedule
✓ Clearer distinction between active and inactive sessions
✓ Visual badges for easy identification
✓ Improved user experience

---

## ✓ Status: IMPLEMENTED AND TESTED
