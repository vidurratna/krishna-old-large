import React, { Component } from 'react'
import { connect } from 'react-redux'

import { Page, Block, Title, SubTitle, Form, CallToAction, SignUp } from './style'

import styled from  'styled-components';


import { store } from 'react-notifications-component'
import { Warning } from '../../Components/Alerts';

import { LazyLoadImage } from 'react-lazy-load-image-component';
import PageSelect from './Components/PageSelect';
import { Input } from '../../Components/Inputs';

const One = () => {
    return(
            <React.Fragment>
                <Input 
                    autoFocus
                    variant="outlined"
                    label="Email!"
                    id="email_login"
                    name="email"
                    
                    type="email"
                    // value={this.state.email}
                    // error={this.state.email_error}
                    // onChange={this.handleChange}
                    aria-describedby="email-error-text"
                />
                <Input 
                    variant="outlined"
                    label="Email!"
                    id="email_login"
                    name="email"
                    
                    type="email"
                    // value={this.state.email}
                    // error={this.state.email_error}
                    // onChange={this.handleChange}
                    aria-describedby="email-error-text"
                />
                <Input 
                    variant="outlined"
                    label="Email!"
                    id="email_login"
                    name="email"
                    
                    type="email"
                    // value={this.state.email}
                    // error={this.state.email_error}
                    // onChange={this.handleChange}
                    aria-describedby="email-error-text"
                />
            </React.Fragment>
    )
}

const Two = () => {
    return(
        <h3 style={{margin:"22px 0px 0px"}}>Two</h3>
    )
}

const Three = () => {
    return(
        <h3 style={{margin:"22px 0px 0px"}}>Three</h3>
    )
}

export class Register extends Component {

    constructor(props) {
        super(props);
        this.state = {
            page_number: 1,
            page: <One/>,
        };

        this.handleChange = this.handleChange.bind(this);
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

    handleChange(number){
        let pages = [<One/>, <Two/>, <Three/>]
        this.setState({
            ...this.state,
            page: pages[number-1],
            page_number: number,
        })
    }

    render() {
        return (
            <Page left>
                <Block left>
                    <Form>
                        <SubTitle>Krishna</SubTitle>
                        <Title>Sign Up</Title>
                        <PageSelect change={this.handleChange} page={this.state.page_number}/>
                        <div>
                            {this.state.page}
                        </div>
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
