document.addEventListener('DOMContentLoaded', function() {
    const WLS = {
        init: function() {
            this.bindEvents();
            this.initModals();
        },

        bindEvents: function() {
            document.querySelectorAll('.add-environment').forEach(btn => {
                btn.addEventListener('click', this.showAddEnvironmentModal.bind(this));
            });

            document.querySelectorAll('.edit-env').forEach(btn => {
                btn.addEventListener('click', this.showEditEnvironmentModal.bind(this));
            });

            document.querySelectorAll('.delete-env').forEach(btn => {
                btn.addEventListener('click', this.deleteEnvironment.bind(this));
            });

            document.querySelectorAll('.create-backup').forEach(btn => {
                btn.addEventListener('click', this.createBackup.bind(this));
            });

            document.querySelectorAll('.transfer-backup').forEach(btn => {
                btn.addEventListener('click', this.showTransferModal.bind(this));
            });

            $('.clone-env').on('click', this.handleCloneClick.bind(this));
        },

        initModals: function() {
            // Initialize modal close buttons
            document.querySelectorAll('.wls-modal-close').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    this.closeModal(e.target.closest('.wls-modal'));
                });
            });
        },

        showAddEnvironmentModal: function(e) {
            e.preventDefault();
            document.getElementById('wls-add-environment-modal').style.display = 'block';
        },

        showEditEnvironmentModal: function(e) {
            e.preventDefault();
            const envId = e.target.dataset.id;
            this.loadEnvironmentData(envId).then(data => {
                // Populate form with environment data
                const modal = document.getElementById('wls-edit-environment-modal');
                modal.querySelector('[name="env_id"]').value = envId;
                modal.querySelector('[name="name"]').value = data.name;
                modal.querySelector('[name="host"]').value = data.host;
                modal.style.display = 'block';
            });
        },

        async loadEnvironmentData(envId) {
            const response = await fetch(`/wp-json/wp-local-sync/v1/environments/${envId}`, {
                headers: {
                    'X-WP-Nonce': wpLocalSync.nonce
                }
            });
            return await response.json();
        },

        async createBackup() {
            try {
                const response = await fetch('/wp-json/wp-local-sync/v1/backup', {
                    method: 'POST',
                    headers: {
                        'X-WP-Nonce': wpLocalSync.nonce
                    }
                });
                const data = await response.json();
                if (data.success) {
                    this.showNotice('Backup created successfully', 'success');
                    this.refreshBackupsList();
                }
            } catch (error) {
                this.showNotice('Failed to create backup', 'error');
            }
        },

        async transferBackup(backupId, targetEnvId) {
            try {
                const response = await fetch(`/wp-json/wp-local-sync/v1/backups/transfer/${backupId}`, {
                    method: 'POST',
                    headers: {
                        'X-WP-Nonce': wpLocalSync.nonce,
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        target_environment_id: targetEnvId
                    })
                });
                const data = await response.json();
                if (data.success) {
                    this.showNotice('Backup transferred successfully', 'success');
                }
            } catch (error) {
                this.showNotice('Failed to transfer backup', 'error');
            }
        },

        showNotice: function(message, type = 'success') {
            const notice = document.createElement('div');
            notice.className = `notice notice-${type} is-dismissible`;
            notice.innerHTML = `<p>${message}</p>`;
            document.querySelector('.wrap').insertBefore(notice, document.querySelector('.wrap').firstChild);
        },

        closeModal: function(modal) {
            modal.style.display = 'none';
        },

        async handleCloneClick(e) {
            e.preventDefault();
            // Implementation needed
        }
    };

    WLS.init();
}); 