
import React, { Component } from 'react'

import { store } from 'react-notifications-component'
import { Error } from '../../../Components/Alerts';
import Text from '../../../Components/Inputs/Text';
import Button from '../../../Components/Inputs/Button';
import { faSignInAlt } from '@fortawesome/free-solid-svg-icons';
import { api } from '../../../Services/Api';

export default class LoginForm extends Component {


    constructor(props) {
        super(props);
        this.state = {
            errors: {},
            fields: {
                email: "",
                password: "",
            },
            loading: false,
        };

        this.handleChange = this.handleChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);

    }

    handleChange(event) {   
        this.setState({
            ...this.state,
            fields: {
                ...this.state.fields,
                [event.target.name]: event.target.value,
            }
        })
    }

    handleSubmit(event) {
        event.preventDefault();
        this.setState({...this.state, errors: {}, loading: true})
        api.post('user/login', this.state.fields)
            .then(res => {
                this.setState({...this.state, loading: false});
                api.interceptors.request.use(function (config) {
                    config.headers = {...config.headers, "authorization": "Bearer "+res.data.token}
                    return config;
                }, function( error ) {
                    return Promise.reject(error);
                })
                window.localStorage.setItem('krishna_token', res.data.token);
                this.props.submit(res.data);
            })
            .catch(error => {
                switch(error.response.status){
                    case 422:
                        this.setState({errors:error.response.data.errors})
                        break
                    case 401:
                        this.setState({
                            errors: {
                                email: "Email or password is incorrect",
                                password: true,
                            }
                        })
                        break
                    default:
                        store.addNotification({
                            content: <Error message="Something has gone wrong, please try again later!"/>,
                            insert: "bottom",
                            container: "bottom-left",
                            animationIn: ['animated', 'fadeInLeft'],
                            animationOut: ['animated', 'fadeOutLeft'],
                            dismiss: {
                                duration: 4000,
                            }
                        })
                }
                this.setState({...this.state, loading: false})
            })
            // let url = window.location.hostname;
            // this.setState({...this.state, loading: true})
            // Axios.post("https://"+url+"/api/v1/user/login", {
            //     email: this.state.email,
            //     password: this.state.password
            // })
            //     .then(res => {
            //         setTimeout(() => {
            //             this.props.submit(res.data);
            //         }, 100);
            //         this.setState({...this.state, loading: false})
            //     })
            //     .catch(error => {
            //         if(error.response.status === 401){
            //             setTimeout(() => {
            //                 store.addNotification({
            //                     content: <Error message="Incorrect Email or Password!"/>,
            //                     insert: "bottom",
            //                     container: "bottom-left",
            //                     animationIn: ['animated', 'fadeInLeft'],
            //                     animationOut: ['animated', 'fadeOutLeft'],
            //                     dismiss: {
            //                         duration: 4000,
            //                     }
            //                 })
            //             }, 100);
            //         } else {
            //             console.log(error)
            //         }
            //         this.setState({...this.state, loading: false})
            //     })
        }
        

    render() {
        return (
            // <Form onSubmit={this.handleSubmit}>
            //       <TextInput
            //             label="Email"
            //             id="email_login"
            //             name="email"
            //             type="email"
            //             onChange={this.handleChange}
            //             value={this.state.email}
            //             error={this.state.email_error}
            //             errorMsg="Please enter a valid email!"
            //         />
            //         <TextInput
            //             label="Password"
            //             id="password_login"
            //             name="password"
            //             type="password"
            //             forgotPassword
            //             onChange={this.handleChange}
            //             value={this.state.password}
            //             error={this.state.password_error}
            //             errorMsg="Please enter a valid password!"
            //         />
            //         <Button
            //             text="Login"
            //             type="submit"
            //             loading={this.state.loading}
            //         />
            // </Form>
            <form onSubmit={this.handleSubmit}>
                <Text
                    label="Email"
                    id="email"
                    name="email"
                    type="email" 
                    onChange={this.handleChange}
                    value={this.state.fields.email}
                    error={this.state.errors.email}
                />
                <Text
                    label="Password"
                    id="password"
                    name="password"
                    type="password" 
                    onChange={this.handleChange}
                    value={this.state.fields.password}
                    error={this.state.errors.password}
                />
                <Button
                    text="Sign In"
                    type="submit"
                    loading={this.state.loading}
                    icon={faSignInAlt}
                />
            </form>
        )
    }
}
