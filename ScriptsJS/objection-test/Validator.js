const { Validator: ValidatorObjection, ValidationError } = require('objection');
const yup = require('yup');

const yup_options = {
    abortEarly: false
};

const getErrors = (errors) => {
    if (errors.errors) {
        const error_object = {};

        errors.inner.forEach((v, i) => {
            error_object[v.path] = v.message;
        });

        error_object.error_count = errors.errors.length;

        return new ValidationError({ type: 'yup-validation', message: 'Validation failed', data: error_object });
    } else {
        return errors;
    }
};

class Validator extends ValidatorObjection {
    validate (args) {
        const { json, model } = args;

        const { rules } = model;

        const shape_rules = yup.object().shape(rules);

        // console.log(shape_rules);
        //
        const object_args = shape_rules.validate(json, yup_options)
            .then(object => object)
            .catch(errors => getErrors(errors));

        console.log(object_args);
        //
        // if (object_args instanceof ValidationError) {
        //     throw object_args;
        // } else {
            return json;
        // }
    }

    beforeValidate (args) {
        // Takes the same arguments as `validate`. Usually there is no need
        // to override this.
        return super.beforeValidate(args);
    }

    afterValidate (args) {
        // Takes the same arguments as `validate`. Usually there is no need
        // to override this.
        return super.afterValidate(args);
    }

}

module.exports = { Validator };