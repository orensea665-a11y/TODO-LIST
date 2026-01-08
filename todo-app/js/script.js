// Global variables
let currentSection = 'tasks';

// Show/hide sections
function showSection(sectionId) {
    document.querySelectorAll('.section').forEach(section => section.classList.remove('active'));
    document.getElementById(sectionId).classList.add('active');
    currentSection = sectionId;
    loadData(sectionId);
}

// Show/hide forms
function showForm(formId) {
    document.getElementById(formId).style.display = 'block';
    if (formId === 'task-form') {
        document.getElementById('task-form-title').textContent = 'Add Task';
        document.getElementById('task-id').value = '';
        document.getElementById('task-title').value = '';
        document.getElementById('task-description').value = '';
        document.getElementById('task-status').value = 'pending';
        document.getElementById('task-due-date').value = '';
        loadCategoriesForTask();
    } else if (formId === 'category-form') {
        document.getElementById('category-form-title').textContent = 'Add Category';
        document.getElementById('category-id').value = '';
        document.getElementById('category-name').value = '';
        document.getElementById('category-description').value = '';
    }
}

function hideForm(formId) {
    document.getElementById(formId).style.display = 'none';
}

// Load data dynamically
function loadData(section) {
    showLoading();
    if (section === 'tasks') {
        fetch('php/get_tasks.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('task-list').innerHTML = data;
                hideLoading();
            })
            .catch(error => showMessage('Error loading tasks: ' + error.message, 'error'));
    } else if (section === 'categories') {
        fetch('php/get_categories.php')
            .then(response => response.text())
            .then(data => {
                document.getElementById('category-list').innerHTML = data;
                hideLoading();
            })
            .catch(error => showMessage('Error loading categories: ' + error.message, 'error'));
    }
}

// Load categories for task form (enhanced with error handling)
function loadCategoriesForTask() {
    return fetch('php/get_categories.php')
        .then(response => response.text())
        .then(data => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(data, 'text/html');
            const table = doc.querySelector('.table');
            const select = document.getElementById('task-category');
            select.innerHTML = '<option value="">Select Category</option>';
            if (table) {
                const rows = table.querySelectorAll('tbody tr');
                if (rows.length === 0) {
                    select.innerHTML = '<option value="" disabled>No categories available. Add one first.</option>';
                    select.disabled = true;  // Disable if no categories
                    showMessage('No categories found. Please add a category before creating tasks.', 'error');
                } else {
                    select.disabled = false;
                    rows.forEach(row => {
                        const id = row.cells[2].querySelector('.btn-edit').getAttribute('onclick').match(/\d+/)[0];
                        const name = row.cells[0].textContent;
                        select.innerHTML += `<option value="${id}">${name}</option>`;
                    });
                }
            } else {
                select.innerHTML = '<option value="" disabled>Error loading categories.</option>';
                select.disabled = true;
                showMessage('Error loading categories. Check your setup.', 'error');
            }
        })
        .catch(error => {
            console.error('Error loading categories for task: ' + error);
            showMessage('Failed to load categories. Please try again.', 'error');
        });
}

// Edit actions
function editTask(id) {
    fetch(`php/get_task.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showMessage(data.error, 'error');
                return;
            }
            document.getElementById('task-form-title').textContent = 'Edit Task';
            document.getElementById('task-id').value = data.id;
            document.getElementById('task-title').value = data.title;
            document.getElementById('task-description').value = data.description;
            document.getElementById('task-status').value = data.status;
            document.getElementById('task-due-date').value = data.due_date;
            loadCategoriesForTask().then(() => {
                document.getElementById('task-category').value = data.category_id;
            });
            showForm('task-form');
        })
        .catch(error => showMessage('Error loading task: ' + error.message, 'error'));
}

function editCategory(id) {
    fetch(`php/get_category.php?id=${id}`)
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                showMessage(data.error, 'error');
                return;
            }
            document.getElementById('category-form-title').textContent = 'Edit Category';
            document.getElementById('category-id').value = data.id;
            document.getElementById('category-name').value = data.name;
            document.getElementById('category-description').value = data.description;
            showForm('category-form');
        })
        .catch(error => showMessage('Error loading category: ' + error.message, 'error'));
}

// Delete actions
function deleteTask(id) {
    if (confirm('Are you sure you want to delete this task?')) {
        const formData = new FormData();
        formData.append('id', id);
        fetch('php/delete_task.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.success, 'success');
                    loadData('tasks');
                } else {
                    showMessage(data.error, 'error');
                }
            })
            .catch(error => showMessage('Error deleting task: ' + error.message, 'error'));
    }
}

function deleteCategory(id) {
    if (confirm('Are you sure you want to delete this category?')) {
        const formData = new FormData();
        formData.append('id', id);
        fetch('php/delete_category.php', { method: 'POST', body: formData })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage(data.success, 'success');
                    loadData('categories');
                } else {
                    showMessage(data.error, 'error');
                }
            })
            .catch(error => showMessage('Error deleting category: ' + error.message, 'error'));
    }
}

// Form submissions
document.getElementById('task-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const title = document.getElementById('task-title').value.trim();
    const category = document.getElementById('task-category').value;
    if (!title || !category) {
        showMessage('Title and category are required.', 'error');
        return;
    }
    const formData = new FormData(this);
    const url = formData.get('id') ? 'php/update_task.php' : 'php/add_task.php';
    showLoading();
    fetch(url, { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            if (data.success) {
                showMessage(data.success, 'success');
                hideForm('task-form');
                loadData('tasks');
            } else {
                showMessage(data.error, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            showMessage('Error saving task: ' + error.message, 'error');
        });
});

document.getElementById('category-form').addEventListener('submit', function(e) {
    e.preventDefault();
    // Debugging: Log the form data to console
    console.log('Category form submitted');
    const name = document.getElementById('category-name').value.trim();
    console.log('Name value:', name);  // Check if this shows your input
    // Removed client-side check to avoid conflicts; rely on server-side
    const formData = new FormData(this);
    console.log('FormData entries:', Array.from(formData.entries()));  // See what's being sent
    const url = formData.get('id') ? 'php/update_category.php' : 'php/add_category.php';
    showLoading();
    fetch(url, { method: 'POST', body: formData })
        .then(response => response.json())
        .then(data => {
            hideLoading();
            console.log('Server response:', data);  // Debug server response
            if (data.success) {
                showMessage(data.success, 'success');
                hideForm('category-form');
                loadData('categories');
            } else {
                showMessage(data.error, 'error');
            }
        })
        .catch(error => {
            hideLoading();
            console.log('Fetch error:', error);  // Debug fetch issues
            showMessage('Error saving category: ' + error.message, 'error');
        });
});

// Utility functions
function showLoading() {
    document.getElementById('loading').style.display = 'block';
}

function hideLoading() {
    document.getElementById('loading').style.display = 'none';
}

function showMessage(message, type) {
    const msgEl = document.getElementById('message');
    msgEl.textContent = message;
    msgEl.style.backgroundColor = type === 'error' ? '#e74c3c' : '#27ae60';
    msgEl.style.display = 'block';
    setTimeout(() => msgEl.style.display = 'none', 3000);
}

// Initial load
document.addEventListener('DOMContentLoaded', () => {
    loadData('tasks');
});