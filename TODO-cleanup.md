# TODO: Code Cleanup for LaporanController and Views

## Form Request
- [x] Create app/Http/Requests/LaporanRequest.php for validation rules

## Controller Refactor
- [x] Update LaporanController to use LaporanPolicy for authorization instead of manual checks
- [x] Remove inline validation from store and update methods, use LaporanRequest
- [x] Simplify controller methods by leveraging policy

## JavaScript Separation
- [x] Create resources/js/laporan.js and move inline JS from index.blade.php
- [x] Update index.blade.php to include the external JS file

## Testing
- [ ] Test CRUD operations to ensure functionality remains intact
- [ ] Run existing tests to verify no regressions
