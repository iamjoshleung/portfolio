import Alert from "../components/Alert.vue";

export default {
    components: {
        Alert
    },
    data() {
        return {
            message: {
                type: "",
                body: ""
            }
        };
    },
    methods: {
        setMessage(type, body) {
            this.message.type = type;
            this.message.body = body;

            setTimeout(_ => {
                this.message.type = "";
                this.message.body = "";
            }, 3000);
        }
    }
};
