import React, { Component } from 'react'
import { Input } from '../../../Components/Inputs';

export default class RegisterForm extends Component {

    constructor(props) {
        super(props);
        this.state = {
            email: "",
            email_error: false,
            password_error: false,
            password: "",
            loading: false,
        };

        this.handleChange = this.handleChange.bind(this);
        // this.handleSubmit = this.handleSubmit.bind(this);
    }

    handleChange(event) {
        this.setState({
            ...this.state,
            [event.target.name]: event.target.value,
        })
    }

    render() {
        return (
            <form>
                <Input 
                    autoFocus
                    variant="outlined"
                    label="Email!"
                    id="email_login"
                    name="email"
                    value={this.state.email}
                    type="email"
                    error={this.state.email_error}
                    onChange={this.handleChange}
                    aria-describedby="email-error-text"
                />
            </form>
        )
    }
}
