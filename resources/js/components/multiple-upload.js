let multipleUpload = function (model, oldFiles, maxFiles, maxSize, allowedTypes, translatedAttribute, translatedFormats) {
    return {
        oldFiles: oldFiles || [],
        files: [],
        items: [],
        dragging: false,
        model: model,
        uploading: false,
        maxFiles: maxFiles,
        maxSize: maxSize,
        allowedTypes: allowedTypes,
        translatedAttribute: translatedAttribute,
        translatedFormats: translatedFormats,
        init() {
            if (this.oldFiles.length > 0) {
                this.oldFiles = this.oldFiles.map((file) => ({
                    id: file.id,
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    preview: file.preview,
                    progress: 100,
                }));
            }
        },
        handleDrop(files) {
            this.dragging = false;
            this.$refs.input.files = files;
            this.$refs.input.dispatchEvent(new Event('change', { bubbles: true }));
        },
        addFiles(files) {
            files = Array.from(files || []);
            if (files.length === 0) return;
            this.$refs.input.value = '';
            this.$dispatch('clear-validation-errors');

            if (!this.checkAllFilesIsValid(files)) {
                return;
            }

            for (const file of files) {
                this.files.push({
                    name: file.name,
                    size: file.size,
                    type: file.type,
                    key: `${Date.now()}-${Math.floor(Math.random() * 100000)}`,
                    preview: URL.createObjectURL(file),
                    progress: 0,
                    status: 'queued',
                    temporaryFilename: null,
                    removalRequested: false,
                });
            }

            if (files.length === 0) return;

            this.items = [...this.items, ...files];

            this.uploadPendingFiles();
        },
        uploadPendingFiles() {
            if (this.uploading) return;

            const batch = this.files.filter((file) => file.status === 'queued');
            if (batch.length === 0) return;

            const items = batch.map((file) => this.items[this.files.indexOf(file)]);
            batch.forEach((file) => (file.status = 'uploading'));
            this.uploading = true;

            const failed = () => {
                this.$dispatch('validation-error-alert', {
                    model: this.model,
                    message: `Não foi possível enviar ${batch.map((file) => file.name).join(', ')}. Selecione novamente para tentar de novo.`,
                });
                batch.forEach((file) => this.discardFile(file.key));
                this.uploading = false;
                this.uploadPendingFiles();
            };

            this.$wire.uploadMultiple(
                this.model,
                items,
                (temporaryFilenames) => {
                    batch.forEach((file, index) => {
                        const current = this.files.find((candidate) => candidate.key === file.key);
                        if (current) {
                            current.temporaryFilename = temporaryFilenames[index];
                            current.status = 'uploaded';
                            current.progress = 100;
                            if (current.removalRequested) {
                                this.removeTemporaryFile(current);
                            }
                        }
                    });
                    this.uploading = false;
                    this.uploadPendingFiles();
                },
                failed,
                (event) => {
                    this.handleUploadProgress(event.detail.progress);
                },
                failed,
            );
        },
        checkAllFilesIsValid(files) {
            if (!this.validateMaxFiles(files)) {
                return false;
            }

            for (const file of files) {
                if (!this.validateFileType(file) || !this.validateFileSize(file)) {
                    return false;
                }
            }

            return true;
        },
        validateMaxFiles(files) {
            if (this.oldFiles.length + this.items.length + files.length > this.maxFiles) {
                this.$dispatch('validation-error-alert', {
                    model: this.model,
                    message: `O campo ${this.translatedAttribute} deve conter no máximo ${this.maxFiles} arquivos.`,
                });

                return false;
            }

            return true;
        },
        validateFileType(file) {
            if (
                !this.allowedTypes.split(',').some((value) => {
                    const type = value.trim().toLowerCase();
                    const mime = file.type.toLowerCase();
                    return (
                        type === '*/*' ||
                        (type !== '' &&
                            (type === mime || (/^[^/*]+\/\*$/.test(type) && mime.startsWith(type.slice(0, -1)) && mime.split('/')[1])))
                    );
                })
            ) {
                this.$dispatch('validation-error-alert', {
                    model: this.model,
                    message: `O arquivo ${file.name} não é um tipo permitido para o campo ${this.translatedAttribute}.`,
                    description: 'Tipos permitidos: ' + this.translatedFormats,
                });

                return false;
            }

            return true;
        },
        validateFileSize(file) {
            if (file.size > this.maxSize * 1024) {
                // kb to bytes conversion
                this.$dispatch('validation-error-alert', {
                    model: this.model,
                    message: `O arquivo ${file.name} excede o tamanho máximo permitido de ${this.maxSize / 1024} MB para o campo ${this.translatedAttribute}.`,
                });

                return false;
            }

            return true;
        },
        handleUploadProgress(globalProgress) {
            this.files
                .filter((file) => file.status === 'uploading')
                .forEach((file) => {
                    file.progress = Math.min(99, Math.round(globalProgress));
                });
        },
        removeFile(index, oldFile = false) {
            if (oldFile) {
                const file = this.oldFiles[index];
                this.oldFiles.splice(index, 1);
                this.$wire.dispatch('remove::file', { mediaId: file.id });

                return;
            }

            const file = this.files[index];
            if (!file || file.removalRequested) return;

            if (file.status === 'queued') {
                this.discardFile(file.key);
                return;
            }

            file.removalRequested = true;
            if (file.temporaryFilename) {
                this.removeTemporaryFile(file);
            }
        },
        removeTemporaryFile(file) {
            // Keep the card until Livewire confirms removal, including on network failure.
            this.$wire.removeUpload(this.model, file.temporaryFilename, () => {
                this.discardFile(file.key);
            });
        },
        discardFile(key) {
            const index = this.files.findIndex((file) => file.key === key);
            if (index === -1) return;

            URL.revokeObjectURL(this.files[index].preview);
            this.files.splice(index, 1);
            this.items.splice(index, 1);
        },
        destroy() {
            this.files.forEach((file) => URL.revokeObjectURL(file.preview));
        },
        getPreviewMimeTypes(type) {
            if (type === 'image') {
                return ['png', 'gif', 'bmp', 'svg', 'jpg', 'jpeg', 'webp'];
            }

            if (type === 'video') {
                return ['wav', 'mp4', 'mov', 'avi', 'wmv', 'mp3', 'm4a', 'mpga', 'wma'];
            }

            if (type === 'document') {
                return [
                    'pdf',
                    'doc',
                    'docx',
                    'application/pdf',
                    'application/msword',
                    'application/vnd.ms-word',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                ];
            }

            return [];
        },
        getPreviewId(prefix, type, index) {
            return `${prefix}-${type}-preview-${index}`;
        },
    };
};

export default multipleUpload;
