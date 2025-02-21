document.addEventListener('DOMContentLoaded', function () {
    // افزودن گروه جدید با AJAX
    document.getElementById('saveGroupBtn').addEventListener('click', function () {
        const groupName = document.getElementById('new_group_name').value;
        const parentGroupId = document.getElementById('parent_group_id').value;

        if (!groupName) {
            alert('لطفاً نام گروه را وارد کنید.');
            return;
        }

        const formData = new FormData();
        formData.append('group_name', groupName);
        formData.append('parent_group_id', parentGroupId);

        fetch('/loco/includes/groups.php?action=add', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // افزودن گروه جدید به dropdown
                const groupSelect = document.getElementById('group_id');
                const newOption = document.createElement('option');
                newOption.value = data.group_id;
                newOption.textContent = groupName;
                groupSelect.appendChild(newOption);

                // بستن مودال
                $('#addGroupModal').modal('hide');
                alert('گروه با موفقیت افزوده شد.');
            } else {
                alert('خطا در افزودن گروه.');
            }
        })
        .catch(error => console.error('خطا:', error));
    });

    // جستجو در لیست خطاها
    const searchError = document.getElementById('searchError');
    if (searchError) {
        searchError.addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#errorTableBody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchValue)) {
                        match = true;
                    }
                });
                row.style.display = match ? '' : 'none';
            });
        });
    }

    // فعال‌سازی منوهای کشویی
    $('.dropdown-toggle').dropdown();

    // جستجو در لیست گروه‌ها
    const searchGroup = document.getElementById('searchGroup');
    if (searchGroup) {
        searchGroup.addEventListener('input', function () {
            const searchValue = this.value.toLowerCase();
            const rows = document.querySelectorAll('#groupTableBody tr');

            rows.forEach(row => {
                const cells = row.querySelectorAll('td');
                let match = false;
                cells.forEach(cell => {
                    if (cell.textContent.toLowerCase().includes(searchValue)) {
                        match = true;
                    }
                });
                row.style.display = match ? '' : 'none';
            });
        });
    }
});