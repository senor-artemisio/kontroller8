import {MDCTextField} from '@material/textfield';

class Field {
    default() {
        return {
            data: function () {
                return {
                    field: null
                };
            },
            props: {
                id: {
                    type: String,
                },
                title: {
                    type: String
                },
                value: {}
            },
            mounted() {
                this.$data.field = new MDCTextField(document.querySelector('#' + this.id));
                this.$data.field.useNativeValidation = false;
            },
            methods: {
                setError(message) {
                    this.$data.field.valid = false;
                    this.$data.field.helperTextContent = message;
                },
                clear() {
                    this.$data.field.valid = true;
                    this.$data.field.helperTextContent = '';
                },
                getValue() {
                    return this.$data.field.value;
                },
            }
        }
    }
}

export default new Field();