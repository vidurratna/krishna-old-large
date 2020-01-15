import React, { Component } from 'react'
import { connect } from 'react-redux'

import { Page, Block, Title, SubTitle, Form, CallToAction, SignUp } from './style'

import { store } from 'react-notifications-component'
import { Warning, Success } from '../../Components/Alerts';

import { LazyLoadImage } from 'react-lazy-load-image-component';

import RegisterForm from './Components/RegisterForm';
import { SIGN_IN } from '../../Redux/actionTypes';

export class Register extends Component {

    constructor(props) {

        super(props);

        this.handleSubmit = this.handleSubmit.bind(this);

    }

    handleLoginRedirect() {

        setTimeout(() => {
            store.addNotification({
                content: <Success message="You have been signed up!"/>,
                insert: "bottom",
                container: "bottom-left",
                animationIn: ['animated', 'fadeInLeft'],
                animationOut: ['animated', 'fadeOutLeft'],
                dismiss: {
                    duration: 3000,
                }
            })
        }, 100);
        this.props.history.replace("/")
    }

    handleSubmit(data){
        this.props.sign_in(data);
        this.handleLoginRedirect();
    }

    componentDidMount() {

        document.title = "Register - Krishna";

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

    }

    render() {
        return (
            <Page left>
                <Block left>
                    <Form>
                        <SubTitle>Krishna</SubTitle>
                        <Title>Sign Up</Title>
                        <RegisterForm submit={this.handleSubmit}/>
                    </Form>
                    <div>
                        <CallToAction>
                            Already a member? 
                            <SignUp
                                to="/login"
                            >login now!
                            </SignUp>
                        </CallToAction>
                    </div>
                </Block>
                <LazyLoadImage
                    placeholderSrc={"https://thelogocompany.net/wp-content/uploads/2016/05/gradient.jpg"}
                    src={"https://picsum.photos/600/1000"}
                />
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


export default connect(mapStateToProps, mapDispatchToProps)(Register)
