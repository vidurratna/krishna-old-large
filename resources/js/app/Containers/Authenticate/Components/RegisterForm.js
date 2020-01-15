// import React, { Component } from 'react'

// import styled from  'styled-components';

// import TextInput from '../../../Components/Inputs/Text'
// import Select from '../../../Components/Inputs/Select';
// import Button from '../../../Components/Inputs/Button';
// import SpecialInput from '../../../Components/Inputs/TextSpecial';
// import PageSelect from './PageSelect';

// import Axios from 'axios'
// import { Error } from '../../../Components/Alerts';
// import { store } from 'react-notifications-component'
// import AddressInput from '../../../Components/Inputs/Address';

// export const Form = styled.form`
//   display:flex;
//   flex-direction: column;
//   max-width: 600px;
// `

// export default class RegisterForm extends Component {

//     constructor(props) {
//         super(props);
//         this.state = {
//             errors: {},
//             fields: {
//                 title: "",
//                 first_name: "",
//                 last_name: "",
//                 phone: "",
//                 date_of_birth: "",
//                 address: "",
//                 city: "",
//                 region: "",
//                 postal_code: "",
//                 country:"",
//                 email: "",
//                 password: "",
//                 password_confirmation: "",
//             },
//             loading: false,
//             page_number: 1,
//             page_error: {
//                 page1: false,
//                 page2: false,
//                 page3: false,
//             }
//         };

//         this.handleChange = this.handleChange.bind(this);
//         this.handleSubmit = this.handleSubmit.bind(this);
//         this.handlePageChange = this.handlePageChange.bind(this);
//     }

//     handleChange(event) {
        
//         if(event.target.address){
//             this.setState({
//                 ...this.state,
//                 fields: {
//                     ...this.state.fields,
//                     ...event.target.fields
//                 }
//             });  
            
//             setTimeout(() => {
//                 this.setState({
//                     page_number: 1,
//                 });
//                 this.setState({
//                     page_number: 2,
//                 });
//             }, 100);
//         } else {
//             this.setState({
//                 ...this.state,
//                 fields: {
//                     ...this.state.fields,
//                     [event.target.name]: event.target.value,
//                 }
//             })
//         }
//     }

//     handlePageChange(number) {
//         this.setState({
//             page_number: number,
//         })
//     }

//     handleSubmit(event) {
//         event.preventDefault();

//         let url = window.location.hostname;
//         this.setState({...this.state, loading: true})
//         Axios.post("https://"+url+"/api/v1/user/register", {
//             ...this.state.fields
//         })
//             .then(res => {
//                 setTimeout(() => {
//                     this.props.submit(res.data);
//                 }, 100);
//                 this.setState({...this.state, loading: false})
//             })
//             .catch(error => {
//                 if(error.response.status === 500){
//                     console.log(error.response);
//                     setTimeout(() => {
//                         store.addNotification({
//                             content: <Error message="Something has gone wrong, please try again later!"/>,
//                             insert: "bottom",
//                             container: "bottom-left",
//                             animationIn: ['animated', 'fadeInLeft'],
//                             animationOut: ['animated', 'fadeOutLeft'],
//                             dismiss: {
//                                 duration: 4000,
//                             }
//                         })
//                     }, 100);
//                 } else if(error.response.status === 422){
//                     let errors = error.response.data.errors;
//                     let page_error = {
//                         page1: false,
//                         page2: false,
//                         page3: false,
//                     }
//                     if(errors.title || errors.first_name || errors.last_name || errors.date_of_birth || errors.phone){
//                         page_error.page1 = true
//                     }

//                     if(errors.address || errors.city || errors.region || errors.postal_code || errors.country){
//                         page_error.page2 = true
//                     }

//                     if(errors.email || errors.password ){
//                         page_error.page3 = true
//                     }

//                     this.setState({...this.status, errors: errors, page_error: page_error})
//                 } else {
//                     console.log(error.response)
//                 }
//                 this.setState({...this.state, loading: false})
//             })

//     }

//     render() {

        
//         return (
//             <h1></h1>
//             // <Form onSubmit={this.handleSubmit}>
//             //     <PageSelect error={this.state.page_error} page={this.state.page_number} change={this.handlePageChange}/>
//             //     {this.state.page_number === 1 ? 
//             //         <React.Fragment>
//             //             <Select
//             //                 label="Title"
//             //                 id="title_register"
//             //                 name="title"
//             //                 value={this.state.title}
//             //                 onChange={this.handleChange}
//             //                 error={this.state.errors.title ? true : false}
//             //                 errorMsg={this.state.errors.title}
//             //                 options={["Master", "Mr", "Mrs", "Miss", "Ms", "Dr"]}
//             //             />
//             //             <TextInput
//             //                 label="First Name"
//             //                 id="first_name_register"
//             //                 name="first_name"
//             //                 type="text"
//             //                 value={this.state.fields.first_name}
//             //                 onChange={this.handleChange}
//             //                 error={this.state.errors.first_name ? true : false}
//             //                 errorMsg={this.state.errors.first_name}
//             //             />
//             //             <TextInput
//             //                 label="Last Name"
//             //                 id="last_name_register"
//             //                 name="last_name"
//             //                 type="text"
//             //                 value={this.state.fields.last_name}
//             //                 onChange={this.handleChange}
//             //                 error={this.state.errors.last_name ? true : false}
//             //                 errorMsg={this.state.errors.last_name}
//             //             />
//             //             <SpecialInput
//             //                 label="Date of Birth"
//             //                 id="date_of_birth_register"
//             //                 name="date_of_birth"
//             //                 value={this.state.fields.date_of_birth}
//             //                 onChange={this.handleChange}
//             //                 error={this.state.errors.date_of_birth ? true : false}
//             //                 errorMsg={this.state.errors.date_of_birth}
//             //                 mask={[/\d/, /\d/, '/', /\d/, /\d/, '/', /\d/, /\d/, /\d/, /\d/]}
//             //                 helperMsg="Day/Month/Year"
//             //             />
//             //             <SpecialInput
//             //                 label="Phone Number"
//             //                 id="phone_number_register"
//             //                 name="phone"
//             //                 value={this.state.fields.phone}
//             //                 onChange={this.handleChange}
//             //                 error={this.state.errors.phone ? true : false}
//             //                 errorMsg={this.state.errors.phone}
//             //                 mask={[ '+',  /[1-9]/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/,/\d/, /\d/, /\d/]}
//             //             />
//             //             <Button
//             //                 text="Next"
//             //                 onClick={() => this.handlePageChange(2)}
//             //             />
//             //     </React.Fragment>
//             //     : null}
//             //     {this.state.page_number === 2 ? 
//             //         <React.Fragment>
//             //             {/* <TextInput
//             //                 label="Address"
//             //                 id="address_register"
//             //                 name="address"
//             //                 type="text"
//             //                 onChange={this.handleChange}
//             //                 value={this.state.fields.address}
//             //                 error={this.state.errors.address ? true : false}
//             //                 errorMsg={this.state.errors.address}
//             //             /> */}
//             //             <AddressInput
//             //                 label="Address"
//             //                 id="address_register"
//             //                 name="address"
//             //                 type="text"
//             //                 onChange={this.handleChange}
//             //                 value={this.state.fields.address}
//             //                 error={this.state.errors.address ? true : false}
//             //                 errorMsg={this.state.errors.address}
//             //             />
//             //             <TextInput
//             //                 label="City"
//             //                 id="city_register"
//             //                 name="city"
//             //                 type="text"
//             //                 onChange={this.handleChange}
//             //                 value={this.state.fields.city}
//             //                 error={this.state.errors.city ? true : false}
//             //                 errorMsg={this.state.errors.city}
//             //             />
//             //             <TextInput
//             //                 label="Region"
//             //                 id="region_register"
//             //                 name="region"
//             //                 type="text"
//             //                 onChange={this.handleChange}
//             //                 value={this.state.fields.region}
//             //                 error={this.state.errors.region ? true : false}
//             //                 errorMsg={this.state.errors.region}
//             //             />
//             //             <TextInput
//             //                 label="Postal Code"
//             //                 id="postal_code_register"
//             //                 name="postal_code"
//             //                 type="text"
//             //                 onChange={this.handleChange}
//             //                 value={this.state.fields.postal_code}
//             //                 error={this.state.errors.postal_code ? true : false}
//             //                 errorMsg={this.state.errors.postal_code}
//             //             />
//             //             <TextInput
//             //                 label="Country"
//             //                 id="Country_register"
//             //                 name="country"
//             //                 type="text"
//             //                 value={this.state.fields.country}
//             //                 onChange={this.handleChange}
//             //                 error={this.state.errors.country ? true : false}
//             //                 errorMsg={this.state.errors.country}
//             //             />
//             //             <Button
//             //                 text="next"
//             //                 onClick={() => this.handlePageChange(3)}
//             //             />
//             //     </React.Fragment>
//             //     : null}
//             //     {this.state.page_number === 3 ? 
//             //         <React.Fragment>
//             //             <TextInput
//             //                 label="Email"
//             //                 id="email_register"
//             //                 name="email"
//             //                 type="email"
//             //                 onChange={this.handleChange}
//             //                 value={this.state.fields.email}
//             //                 error={this.state.errors.email ? true : false}
//             //                 errorMsg={this.state.errors.email}
//             //             />
//             //             <TextInput
//             //                 label="Password"
//             //                 id="password_register"
//             //                 name="password"
//             //                 type="password"
//             //                 onChange={this.handleChange}
//             //                 value={this.state.fields.password}
//             //                 error={this.state.errors.password ? true : false}
//             //                 errorMsg={this.state.errors.password}
//             //             />
//             //             <TextInput
//             //                 label="Confirm Password"
//             //                 id="password_confirmation_register"
//             //                 name="password_confirmation"
//             //                 type="password"
//             //                 value={this.state.fields.password_confirmation}
//             //                 onChange={this.handleChange}
//             //                 error={this.state.errors.password_confirmation ? true : false}
//             //                 errorMsg={this.state.errors.password_confirmation}
//             //             />
//             //             <Button
//             //                 text="Register"
//             //                 loading={this.state.loading}
//             //                 type="submit"
//             //             />
//             //     </React.Fragment>
//             //     : null}
//             // </Form>
//         )
//     }
// }


import React, { Component } from 'react'
import Text from '../../../Components/Inputs/Text';
import { Grid } from '../../style';
import Select from '../../../Components/Inputs/Select';
import TextSpecial from '../../../Components/Inputs/TextSpecial';
import Button from '../../../Components/Inputs/Button';
import { faSignInAlt } from '@fortawesome/free-solid-svg-icons';
import Address from '../../../Components/Inputs/Address';
import { Error } from '../../../Components/Alerts';
import { store } from 'react-notifications-component'
import Axios from 'axios'
import { api } from '../../../Services/Api';



export default class RegisterForm extends Component {

    constructor(props) {
        super(props);
        this.handlePageChange = this.handlePageChange.bind(this);
        this.handleSubmit = this.handleSubmit.bind(this);
        this.state = {
            errors: {},
            fields: {
                title: "",
                first_name: "",
                last_name: "",
                phone: "",
                date_of_birth: "",
                address: "",
                city: "",
                region: "",
                postal_code: "",
                country:"",
                email: "",
                password: "",
                password_confirmation: "",
            },
            page: 1,
            page_error: {
                page1: false,
                page2: false,
                page3: false,
            },
            loading: false,
        }
    }

    handleChange = event => {
        if(event.target.split){
            this.setState({
                ...this.state,
                fields: {
                    ...this.state.fields,
                    ...event.target.fields,
                }
            })
            setTimeout(() => {
                this.setState({
                    page: 1,
                })
                this.setState({
                    page: 2,
                })
            }, 100);
        } else {
            this.setState({
                ...this.state,
                fields: {
                    ...this.state.fields,
                    [event.target.name]: event.target.value,
                }
            })
        }
    }

    handlePageChange(page) {
        this.setState({
            page: page,
        })
    }

    handleSubmit(event) {
        event.preventDefault();
        this.setState({...this.state, loading: true})
        api.post('user/register', this.state.fields)
            .then(res => {
                this.setState({...this.state, loading: false})
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
                console.log("Error: " + error.response)
                switch(error.response.status){
                    case 422:
                        let errors = error.response.data.errors;
                        let page_error = {
                            page1: false,
                            page2: false,
                            page3: false,
                        }
                        if(errors.title || errors.first_name || errors.last_name || errors.date_of_birth || errors.phone){
                            page_error.page1 = true
                        }

                        if(errors.address || errors.city || errors.region || errors.postal_code || errors.country){
                            page_error.page2 = true
                        }

                        if(errors.email || errors.password ){
                            page_error.page3 = true
                        }

                        this.setState({...this.state, errors: errors})
                        break
                    default:
                        setTimeout(() => {
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
                        }, 100);
                        
                }
                this.setState({...this.state, loading: false})
            })

    }

    PageOne = () => {
        if(this.state.page === 1){
            return(
                <React.Fragment>
                     <Grid columns={"1fr 1fr"}>
                         <Select
                             label="Title"
                             id="title"
                             name="title"
                             value={this.state.fields.title}
                             onChange={this.handleChange}
                             error={this.state.errors.title}
                             options={["Master", "Mr", "Mrs", "Miss", "Ms", "Dr"]}
                         />
                     </Grid>
                     <Grid columns={"1fr 1fr"}>
                         <Text
                             label="First Name"
                             id="first_name"
                             name="first_name"
                             type="text"
                             value={this.state.fields.first_name}
                             onChange={this.handleChange}
                             error={this.state.errors.first_name}
                         />
                         <Text
                             label="Last Name"
                             id="last_name"
                             name="last_name"
                             type="text"
                             value={this.state.fields.last_name}
                             onChange={this.handleChange}
                             error={this.state.errors.last_name}
                         />
                     </Grid>
                     <TextSpecial
                         label="Date of Birth"
                         id="date_of_birth_register"
                         placeholder="DD/MM/YYYY"
                         type="tel"
                         name="date_of_birth"
                         value={this.state.fields.date_of_birth}
                         onChange={this.handleChange}
                         error={this.state.errors.date_of_birth}
                         mask={[/[0-3]/, /\d/, '/', /[0-1]/, /\d/, '/', /[1-2]/, /[0-9]/, /\d/, /\d/]}
                     />
                     <TextSpecial
                         label="Phone Number"
                         id="phone_number_register"
                         name="phone"
                         type="tel"
                         value={this.state.fields.phone}
                         onChange={this.handleChange}
                         placeholder="+00"
                         error={this.state.errors.phone}
                         mask={[ '+',  /[1-9]/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/, /\d/,/\d/, /\d/, /\d/,/\d/, /\d/, /\d/]}
                     />
                     <Button
                        onClick={() => this.handlePageChange(2)}
                         text="Next"
                     />
                </React.Fragment>
             )
        } else return null
    }

    PageTwo = () => {
        if(this.state.page === 2){
            return(
                <React.Fragment>
                    <Address
                        label="Address"
                        id="address"
                        name="address"
                        type="text"
                        value={this.state.fields.address}
                        onChange={this.handleChange}
                        error={this.state.errors.address}
                    />
                    <Text
                        label="Region"
                        id="region"
                        name="region"
                        type="text"
                        value={this.state.fields.region}
                        onChange={this.handleChange}
                        error={this.state.errors.region}
                    />
                    <Grid columns={"1fr 1fr"}>
                        <Text
                            label="City"
                            id="city"
                            name="city"
                            type="text"
                            value={this.state.fields.city}
                            onChange={this.handleChange}
                            error={this.state.errors.city}
                        />
                        <Text
                            label="Postal Code"
                            id="postal_code"
                            name="postal_code"
                            type="text"
                            value={this.state.fields.postal_code}
                            onChange={this.handleChange}
                            error={this.state.errors.postal_code}
                        />
                    </Grid>
                    <Text
                        label="Country"
                        id="country"
                        name="country"
                        type="text"
                        value={this.state.fields.country}
                        onChange={this.handleChange}
                        error={this.state.errors.country}
                    />
                     <Grid columns={"3fr 9fr"}>
                         <Button
                            back
                            onClick={() => this.handlePageChange(1) }
                        />
                        <Button
                            onClick={() => this.handlePageChange(3)}
                            text="Next"
                        />
                     </Grid>
                </React.Fragment>
             )
        } else return null
    }

    PageThree = () => {
        if(this.state.page === 3){
            return(
                <React.Fragment>
                     <Text
                        label="Email"
                        id="email"
                        name="email"
                        type="email"
                        value={this.state.fields.email}
                        onChange={this.handleChange}
                        error={this.state.errors.email}
                    />
                    <Text
                        label="Password"
                        id="password"
                        name="password"
                        type="password"
                        value={this.state.fields.password}
                        onChange={this.handleChange}
                        error={this.state.errors.password}
                    />
                    <Text
                        label="Retype Password"
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        value={this.state.fields.password_confirmation}
                        onChange={this.handleChange}
                        error={this.state.errors.password_confirmation}
                    />
                     <Grid columns={"3fr 9fr"}>
                         <Button
                            back
                            onClick={() => this.handlePageChange(2) }
                        />
                        <Button
                            type="submit"
                            loading={this.state.loading}
                            icon={faSignInAlt}
                            text="Sign Up"
                        />
                     </Grid>
                </React.Fragment>
             )
        } else return null
    }

    render() {
        return (
            <form onSubmit={this.handleSubmit}>
                <this.PageOne/>
                <this.PageTwo/>
                <this.PageThree/>
            </form>
        )
    }
}
