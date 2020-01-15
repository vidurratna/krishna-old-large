import React, { Component } from 'react'

import {Route, Switch, Redirect } from 'react-router-dom';

import Login from '../Containers/Authenticate/Login';
import Register from '../Containers/Authenticate/Register';

import { connect } from 'react-redux';
import AdminPage from '../Containers/Admin';
import Dashboard, {Header as DashboardHeader} from '../Containers/Admin/Containers/Dashboard';
import Account from '../Containers/Authenticate/Account';


class Routes extends Component {
    render() {
        return (
            <Switch>
                <AuthenticatedRoute 
                    exact
                    auth={this.props.Authenticate.isAuthenticated}
                    path="/admin"
                    >
                    <AdminPage
                        content={Dashboard}
                        header={DashboardHeader}
                    />
                </AuthenticatedRoute>
                <AuthenticatedRoute 
                    exact
                    auth={this.props.Authenticate.isAuthenticated}
                    path="/account"
                    >
                    <Account/>
                </AuthenticatedRoute>
                <Route
                component={Login}
                exact
                path="/login"
                />
                <Route
                component={Register}
                exact
                path="/register"
                />
            </Switch>
        )
    }
}


function AuthenticatedRoute({ children, ...rest}) {
    return (
        <Route
            {...rest}
            render={({location}) => rest.auth ? (
                children
                ) : (
                    <Redirect 
                        to={{
                            pathname: "/login",
                            state: {from:  location, unAuthenticated: true}
                        }}
                    />
                )
                }
            />
        );
    } 


    const mapStateToProps = (state) => ({
        Authenticate: state.Auth,
    })

    export default connect(mapStateToProps)(Routes)