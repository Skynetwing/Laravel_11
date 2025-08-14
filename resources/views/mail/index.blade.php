@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Queue Status -->
                <div class="mt-4">
                    <h5>Queue Status</h5>
                    <button type="button" class="btn btn-info" onclick="checkQueueStatus()">Check Queue
                        Status</button>
                    <div id="queueStatus" class="mt-2"></div>
                </div>

                <!-- Response Messages -->
                <div id="responseMessage" class="mt-3"></div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Send Single Email</h4>
                    </div>
                    <div class="card-body">
                        <!-- Single Email Form -->
                        <div class="mb-4">
                            <form id="singleEmailForm" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label for="to" class="form-label">To Email</label>
                                    <input type="email" class="form-control" id="to" name="to" required>

                                </div>
                                <div class="mb-3">
                                    <label for="cc" class="form-label">CC (Comma separated)</label>
                                    <input type="text" class="form-control" id="cc" name="cc" placeholder="email1@example.com, email2@example.com">
                                    <small class="form-text text-muted">Optional: Add CC recipients separated by commas</small>
                                </div>
                                <div class="mb-3">
                                    <label for="bcc" class="form-label">BCC (Comma separated)</label>
                                    <input type="text" class="form-control" id="bcc" name="bcc" placeholder="email1@example.com, email2@example.com">
                                    <small class="form-text text-muted">Optional: Add BCC recipients separated by commas</small>
                                </div>
                                <div class="mb-3">
                                    <label for="subject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="subject" name="subject" required>
                                </div>
                                <div class="mb-3">
                                    <label for="message" class="form-label">Message</label>
                                    <textarea class="form-control" id="message" name="message" rows="4" required></textarea>
                                </div>
                                <div class="mb-3">
                                    <label for="attachments" class="form-label">Attachments</label>
                                    <input type="file" class="form-control" id="attachments" name="attachments[]" multiple>
                                    <small class="form-text text-muted">Optional: Select multiple files (max 10MB each)</small>
                                </div>
                                <div class="mb-3">
                                    <label for="data" class="form-label">Additional Data (JSON)</label>
                                    <textarea class="form-control" id="data" name="data" rows="2" placeholder='{"key": "value"}'></textarea>
                                    <small class="form-text text-muted">Optional: Add custom data as JSON</small>
                                </div>
                                <button type="submit" class="btn btn-primary">Send Email</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-6">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Send Bulk Emails</h4>
                    </div>
                    <div class="card-body">
                        <!-- Bulk Email Form -->
                        <div class="mb-4">
                            <form id="bulkEmailForm" enctype="multipart/form-data">
                                @csrf
                                <div class="mb-3">
                                    <label class="form-label">Email Templates</label>
                                    <div id="emailTemplates">
                                        <!-- Email template will be added here -->
                                    </div>
                                    <button type="button" class="btn btn-sm btn-outline-primary mt-2" onclick="addEmailTemplate()">
                                        <i class="fas fa-plus"></i> Add Email Template
                                    </button>
                                </div>
                                <button type="submit" class="btn btn-success">Send Bulk Emails</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Email Template Modal -->
    <div class="modal fade" id="emailTemplateModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Email Template</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="emailTemplateForm">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="templateTo" class="form-label">To Email</label>
                                    <input type="email" class="form-control" id="templateTo" name="to" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="templateSubject" class="form-label">Subject</label>
                                    <input type="text" class="form-control" id="templateSubject" name="subject" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="templateCc" class="form-label">CC (Comma separated)</label>
                                    <input type="text" class="form-control" id="templateCc" name="cc" placeholder="email1@example.com, email2@example.com">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="templateBcc" class="form-label">BCC (Comma separated)</label>
                                    <input type="text" class="form-control" id="templateBcc" name="bcc" placeholder="email1@example.com, email2@example.com">
                                </div>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="templateMessage" class="form-label">Message</label>
                            <textarea class="form-control" id="templateMessage" name="message" rows="4" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="templateAttachments" class="form-label">Attachments</label>
                            <input type="file" class="form-control" id="templateAttachments" name="attachments[]" multiple>
                            <small class="form-text text-muted">Select multiple files (max 10MB each)</small>
                        </div>
                        <div class="mb-3">
                            <label for="templateData" class="form-label">Additional Data (JSON)</label>
                            <textarea class="form-control" id="templateData" name="data" rows="2" placeholder='{"key": "value"}'></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" onclick="saveEmailTemplate()">Save Template</button>
                </div>
            </div>
        </div>
    </div>

    <script>
        let emailTemplates = [];
        let currentTemplateIndex = -1;

        $(document).ready(function() {
            // Single Email Form Submit
            $('#singleEmailForm').on('submit', function(e) {
                e.preventDefault();
                sendSingleEmail();
            });

            // Bulk Email Form Submit
            $('#bulkEmailForm').on('submit', function(e) {
                e.preventDefault();
                sendBulkEmails();
            });

            // Add first email template
            addEmailTemplate();
        });

        function addEmailTemplate() {
            const templateIndex = emailTemplates.length;
            const templateHtml = `
                <div class="card mb-3 email-template" data-index="${templateIndex}">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h6 class="mb-0">Email Template ${templateIndex + 1}</h6>
                        <div>
                            <button type="button" class="btn btn-sm btn-outline-primary" onclick="editEmailTemplate(${templateIndex})">
                                <i class="fas fa-edit"></i> Edit
                            </button>
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="removeEmailTemplate(${templateIndex})">
                                <i class="fas fa-trash"></i> Remove
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <strong>To:</strong> <span class="template-to">Not set</span><br>
                                <strong>Subject:</strong> <span class="template-subject">Not set</span>
                            </div>
                            <div class="col-md-6">
                                <strong>CC:</strong> <span class="template-cc">Not set</span><br>
                                <strong>BCC:</strong> <span class="template-bcc">Not set</span>
                            </div>
                        </div>
                        <div class="mt-2">
                            <strong>Message:</strong> <span class="template-message">Not set</span><br>
                            <strong>Attachments:</strong> <span class="template-attachments">None</span>
                        </div>
                    </div>
                </div>
            `;

            $('#emailTemplates').append(templateHtml);

            // Initialize empty template
            emailTemplates.push({
                to: '',
                cc: '',
                bcc: '',
                subject: '',
                message: '',
                attachments: [],
                data: ''
            });
        }

        function editEmailTemplate(index) {
            currentTemplateIndex = index;
            const template = emailTemplates[index];

            $('#templateTo').val(template.to);
            $('#templateCc').val(template.cc);
            $('#templateBcc').val(template.bcc);
            $('#templateSubject').val(template.subject);
            $('#templateMessage').val(template.message);
            $('#templateData').val(template.data);

            $('#emailTemplateModal').modal('show');
        }

        function saveEmailTemplate() {
            if (currentTemplateIndex === -1) return;

            const template = {
                to: $('#templateTo').val(),
                cc: $('#templateCc').val(),
                bcc: $('#templateBcc').val(),
                subject: $('#templateSubject').val(),
                message: $('#templateMessage').val(),
                data: $('#templateData').val(),
                attachments: []
            };

            // Handle file attachments
            const fileInput = document.getElementById('templateAttachments');
            if (fileInput.files.length > 0) {
                for (let i = 0; i < fileInput.files.length; i++) {
                    template.attachments.push(fileInput.files[i]);
                }
            }

            emailTemplates[currentTemplateIndex] = template;

            // Update display
            updateTemplateDisplay(currentTemplateIndex, template);

            $('#emailTemplateModal').modal('hide');
            currentTemplateIndex = -1;
        }

        function updateTemplateDisplay(index, template) {
            const templateDiv = $(`.email-template[data-index="${index}"]`);
            templateDiv.find('.template-to').text(template.to || 'Not set');
            templateDiv.find('.template-subject').text(template.subject || 'Not set');
            templateDiv.find('.template-cc').text(template.cc || 'Not set');
            templateDiv.find('.template-bcc').text(template.bcc || 'Not set');
            templateDiv.find('.template-message').text(template.message || 'Not set');
            templateDiv.find('.template-attachments').text(template.attachments.length > 0 ? `${template.attachments.length} file(s)` : 'None');
        }

        function removeEmailTemplate(index) {
            if (emailTemplates.length > 1) {
                emailTemplates.splice(index, 1);
                $(`.email-template[data-index="${index}"]`).remove();

                // Reindex remaining templates
                $('.email-template').each(function(i) {
                    $(this).attr('data-index', i);
                    $(this).find('.card-header h6').text(`Email Template ${i + 1}`);
                    $(this).find('button').attr('onclick', $(this).find('button').attr('onclick').replace(/\d+/, i));
                });
            }
        }

        function sendSingleEmail() {
            const formData = new FormData();
            const form = $('#singleEmailForm')[0];

            // Add form fields
            formData.append('to', $('#to').val());
            formData.append('subject', $('#subject').val());
            formData.append('message', $('#message').val());

            // Add CC and BCC
            const cc = $('#cc').val().trim();
            const bcc = $('#bcc').val().trim();

            if (cc) {
                const ccEmails = cc.split(',').map(email => email.trim()).filter(email => email);
                ccEmails.forEach(email => formData.append('cc[]', email));
            }

            if (bcc) {
                const bccEmails = bcc.split(',').map(email => email.trim()).filter(email => email);
                bccEmails.forEach(email => formData.append('bcc[]', email));
            }

            // Add additional data
            const data = $('#data').val().trim();
            if (data) {
                try {
                    const jsonData = JSON.parse(data);
                    Object.keys(jsonData).forEach(key => {
                        formData.append(`data[${key}]`, jsonData[key]);
                    });
                } catch (e) {
                    // If not valid JSON, ignore
                }
            }

            // Add file attachments
            const fileInput = document.getElementById('attachments');
            if (fileInput.files.length > 0) {
                for (let i = 0; i < fileInput.files.length; i++) {
                    formData.append('attachments[]', fileInput.files[i]);
                }
            }

            $.ajax({
                url: '{{ route('mail.send') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    showResponse(res);
                },
                error: function(xhr) {
                    showResponse({
                        success: false,
                        message: 'Error: ' + xhr.statusText
                    });
                }
            });
        }

        function sendBulkEmails() {
            if (emailTemplates.length === 0) {
                showResponse({
                    success: false,
                    message: 'Please add at least one email template'
                });
                return;
            }

            const formData = new FormData();

            // Add email templates
            emailTemplates.forEach((template, index) => {
                if (template.to && template.subject && template.message) {
                    formData.append(`emails[${index}][to]`, template.to);
                    formData.append(`emails[${index}][subject]`, template.subject);
                    formData.append(`emails[${index}][message]`, template.message);

                    if (template.cc) {
                        const ccEmails = template.cc.split(',').map(email => email.trim()).filter(email => email);
                        ccEmails.forEach(email => formData.append(`emails[${index}][cc][]`, email));
                    }

                    if (template.bcc) {
                        const bccEmails = template.bcc.split(',').map(email => email.trim()).filter(email => email);
                        bccEmails.forEach(email => formData.append(`emails[${index}][bcc][]`, email));
                    }

                    if (template.data) {
                        try {
                            const jsonData = JSON.parse(template.data);
                            Object.keys(jsonData).forEach(key => {
                                formData.append(`emails[${index}][data][${key}]`, jsonData[key]);
                            });
                        } catch (e) {
                            // If not valid JSON, ignore
                        }
                    }

                    // Add file attachments
                    if (template.attachments && template.attachments.length > 0) {
                        template.attachments.forEach(file => {
                            formData.append(`emails[${index}][attachments][]`, file);
                        });
                    }
                }
            });

            $.ajax({
                url: '{{ route('mail.bulk') }}',
                method: 'POST',
                data: formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(res) {
                    showResponse(res);
                },
                error: function(xhr) {
                    showResponse({
                        success: false,
                        message: 'Error: ' + xhr.statusText
                    });
                }
            });
        }

        function checkQueueStatus() {
            $.get('{{ route('mail.status') }}', function(data) {
                let statusDiv = $('#queueStatus');
                if (data.success) {
                    statusDiv.html(`
                <div class="alert alert-success">
                    <strong>Queue Status:</strong> ${data.data.status}<br>
                    <strong>Connection:</strong> ${data.data.queue_connection}<br>
                    <strong>Time:</strong> ${data.data.current_time}
                </div>
            `);
                } else {
                    statusDiv.html(`
                <div class="alert alert-danger">
                    <strong>Error:</strong> ${data.message}
                </div>
            `);
                }
            }).fail(function(xhr) {
                $('#queueStatus').html(`
            <div class="alert alert-danger">
                <strong>Error:</strong> ${xhr.statusText}
            </div>
        `);
            });
        }

        function showResponse(data) {
            let alertClass = data.success ? 'alert-success' : 'alert-danger';
            $('#responseMessage').html(`
        <div class="alert ${alertClass} alert-dismissible fade show">
            <strong>${data.success ? 'Success!' : 'Error!'}</strong> ${data.message}
            ${data.data ? '<br><small>' + JSON.stringify(data.data, null, 2) + '</small>' : ''}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `);
        }
    </script>
@endsection
