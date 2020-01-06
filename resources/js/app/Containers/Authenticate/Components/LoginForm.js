
import React, { Component } from 'react'

import FormControl from '@material-ui/core/FormControl';
import FormHelperText from '@material-ui/core/FormHelperText';
import Button from '@material-ui/core/Button';

import { StylesProvider } from "@material-ui/styles";

import styled from  'styled-components';

import {Input} from '../../../Components/Inputs'

import { SignUp } from '../style';

import { store } from 'react-notifications-component'
import { Error } from '../../../Components/Alerts';


const Btn = styled(Button)`
    margin: 16px 0px;
    padding: 14px;
    background-color: #55514e;
    color: #fff;

    &:hover{ 
        background-color: #a9866c;
    }

`;

export const Form = styled.form`
  display:flex;
  flex-direction: column;
  max-width: 600px;
`

export default class LoginForm extends Component {


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
        this.handleSubmit = this.handleSubmit.bind(this);

    }

    handleChange(event) {
        this.setState({
            ...this.state,
            [event.target.name]: event.target.value,
        })
    }

    handleSubmit(event) {
        event.preventDefault();

        let newState = {
            ...this.state,
            email_error: false,
            password_error: false,
        }
        
        if(this.state.email <= 0){
            newState = {
                ...newState,
                email_error: true,
            }
        }
        if(this.state.password <= 0){
            newState = {
                ...newState,
                password_error: true,
            }
        }

        if(newState.password_error || newState.email_error){
            this.setState(newState);
        } else {
            let url = window.location.hostname;
            this.setState({...this.state, loading: true})
            Axios.post("https://"+url+"/api/v1/user/login", {
                email: this.state.email,
                password: this.state.password
            })
                .then(res => {
                    setTimeout(() => {
                        this.props.submit(res.data);
                    }, 100);
                    this.setState({...this.state, loading: false})
                })
                .catch(error => {
                    if(error.response.status === 401){
                        setTimeout(() => {
                            store.addNotification({
                                content: <Error message="Incorrect Email or Password!"/>,
                                insert: "bottom",
                                container: "bottom-left",
                                animationIn: ['animated', 'fadeInLeft'],
                                animationOut: ['animated', 'fadeOutLeft'],
                                dismiss: {
                                    duration: 4000,
                                }
                            })
                        }, 100);
                    } else {
                        console.log(error)
                    }
                    this.setState({...this.state, loading: false})
                })
        }
        
    }

    render() {
        return (
            <Form onSubmit={this.handleSubmit}>
                  <StylesProvider injectFirst>
                        <FormControl required error={this.state.email_error}>
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
                            {this.state.email_error ? <FormHelperText id="email-error-text">Please enter a email</FormHelperText> : null}
                        </FormControl>
                        <FormControl required error={this.state.password_error}> 
                            <Input
                                variant="outlined"
                                label="Password!"
                                value={this.state.password}
                                id="password_login"
                                type="password"
                                name="password"
                                error={this.state.password_error}
                                onChange={this.handleChange}
                            />
                            {this.state.password_error ? <FormHelperText id="password-error-text"><SignUp error to="/forgot">Forget Password?</SignUp></FormHelperText> : null}
                        </FormControl>
                        <Btn
                            type="submit"
                            variant="contained"
                        >
                            Login!
                        </Btn>
                  </StylesProvider>
            </Form>
        )
    }
}
