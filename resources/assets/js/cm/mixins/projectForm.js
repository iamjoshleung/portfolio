export default {
    mounted() {
        window.Parsley.on("form:submit", () => {
            this.submit();
        });
    },
    methods: {
        onFileChange(e) {
            const files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
                return;
            }
            this.formData.files = files;
        },

        convertDataToFormData() {
            const formData = new FormData();
            Array.from(Object.keys(this.formData)).forEach(key => {
                if (key === "files") {
                    Array.from(this.formData[key]).forEach((file, i) => {
                        formData.append(
                            key + "[]",
                            this.formData[key][i],
                            this.formData[key][i].name
                        );
                    });
                } else if (key === "tags") {
                    this.formData[key].forEach((item, i) =>
                        formData.append(key + "[]", this.formData[key][i])
                    );
                } else {
                    formData.append(key, this.formData[key]);
                }
            });

            return formData;
        }
    }
};
