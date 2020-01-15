import React, { Component } from 'react'

import { connect } from 'react-redux';
import { SIGN_IN } from '../../Redux/actionTypes'

import { store } from 'react-notifications-component'
import { Error, Warning, Success } from '../../Components/Alerts';

import { Page, Block, Title, SubTitle, Form, CallToAction, SignUp } from './style'
import LoginForm from './Components/LoginForm';

import { LazyLoadImage } from 'react-lazy-load-image-component';

export class Login extends Component {

    constructor(props) {

        super(props);

        this.handleSubmit = this.handleSubmit.bind(this);

    }

    componentDidMount() {

        document.title = "Login - Krishna";

        if(this.props.Authenticate.isAuthenticated){

            setTimeout(() => {
                store.addNotification({
                    content: <Warning message="You are already logged in!"/>,
                    insert: "bottom",
                    container: "bottom-left",
                    animationIn: ['animated', 'fadeInLeft'],
                    animationOut: ['animated', 'fadeOutLeft'],
                    dismiss: {
                        duration: 4000,
                    }
                })
            }, 100);
            this.props.history.replace("/");

        }

        if(this.props.location.state) {
            setTimeout(() => {
                store.addNotification({
                    content: <Error message="You need to be logged in to use that page"/>,
                    insert: "bottom",
                    container: "bottom-left",
                    animationIn: ['animated', 'fadeInLeft'],
                    animationOut: ['animated', 'fadeOutLeft'],
                    dismiss: {
                        duration: 4000,
                    }
                })
            }, 100);
        }
    }

    handleLoginRedirect(hasLocation) {

        setTimeout(() => {
            store.addNotification({
                content: <Success message="You have been logged in!"/>,
                insert: "bottom",
                container: "bottom-left",
                animationIn: ['animated', 'fadeInLeft'],
                animationOut: ['animated', 'fadeOutLeft'],
                dismiss: {
                    duration: 3000,
                }
            })
        }, 100);

        hasLocation?
            this.props.history.replace(this.props.location.state.from.pathname) :
            this.props.history.replace("/");
    }


    handleSubmit(data){
        this.props.sign_in(data);
        this.handleLoginRedirect(this.props.location.state)
    }

    
    render() {

        return (
            <Page>
                <LazyLoadImage
                    placeholderSrc={"https://thelogocompany.net/wp-content/uploads/2016/05/gradient.jpg"}
                    src={"https://picsum.photos/600/1000"}
                />
                <Block>
                    <Form>
                        <SubTitle>Krishna</SubTitle>
                        <Title>Login</Title>
                        <LoginForm submit={this.handleSubmit}/>
                    </Form>
                    <div>
                        <CallToAction>
                            Are you new here? 
                            <SignUp
                                to="/register"
                            >sign up now!
                            </SignUp>
                        </CallToAction>
                    </div>
                </Block>
            </Page>
        )
    }
}

const mapStateToProps = (state) => ({
    Authenticate: state.Auth
})

const mapDispatchToProps = (dispatch) => {
    return {
        sign_in: (data) => { dispatch({type: SIGN_IN, value: data})}
    }
}

export default connect(mapStateToProps, mapDispatchToProps)(Login)
