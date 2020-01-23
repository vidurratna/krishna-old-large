import React, { Component } from 'react'

import {Route, Switch, Redirect } from 'react-router-dom';

import Login from '../Containers/Authenticate/Login';
import Register from '../Containers/Authenticate/Register';

import { connect } from 'react-redux';
import AdminPage from '../Containers/Admin';
import AccountPage from '../Containers/Authenticate/Account/index'
import Dashboard, {Header as DashboardHeader} from '../Containers/Admin/Containers/Dashboard';
import Account from '../Containers/Authenticate/Account/Account';
import AccountPersonalDetails from '../Containers/Authenticate/Account/PersonalDeatils';
import Roles from '../Containers/Admin/Containers/Roles/index'
import {Display as DisplayRole} from '../Containers/Admin/Containers/Roles/Display'
import Permissions from '../Containers/Admin/Containers/Permissions/index'
import {Display as DisplayPermission } from '../Containers/Admin/Containers/Permissions/Display'
import Users from '../Containers/Admin/Containers/Users/index'
import {Display as DisplayUsers} from '../Containers/Admin/Containers/Users/Display'


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
                    path="/admin/users"
                    >
                    <AdminPage
                        content={Users}
                        header={DashboardHeader}
                    />
                </AuthenticatedRoute>
                <AuthenticatedRoute 
                    exact
                    auth={this.props.Authenticate.isAuthenticated}
                    path="/admin/users/:id"
                    >
                    <AdminPage
                        content={DisplayUsers}
                        header={DashboardHeader}
                    />
                </AuthenticatedRoute>
                <AuthenticatedRoute 
                    exact
                    auth={this.props.Authenticate.isAuthenticated}
                    path="/admin/roles"
                    >
                    <AdminPage
                        content={Roles}
                        header={DashboardHeader}
                    />
                </AuthenticatedRoute>
                <AuthenticatedRoute 
                    exact
                    auth={this.props.Authenticate.isAuthenticated}
                    path="/admin/roles/:id"
                    >
                    <AdminPage
                        content={DisplayRole}
                        header={DashboardHeader}
                    />
                </AuthenticatedRoute>
                <AuthenticatedRoute 
                    exact
                    auth={this.props.Authenticate.isAuthenticated}
                    path="/admin/permissions"
                    >
                    <AdminPage
                        content={Permissions}
                        header={DashboardHeader}
                    />
                </AuthenticatedRoute>
                <AuthenticatedRoute 
                    exact
                    auth={this.props.Authenticate.isAuthenticated}
                    path="/admin/permissions/:id"
                    >
                    <AdminPage
                        content={DisplayPermission}
                        header={DashboardHeader}
                    />
                </AuthenticatedRoute>
                <AuthenticatedRoute 
                    exact
                    auth={this.props.Authenticate.isAuthenticated}
                    path="/account"
                    >
                    <AccountPage
                        content={Account}
                    />
                </AuthenticatedRoute>
                <AuthenticatedRoute 
                    exact
                    auth={this.props.Authenticate.isAuthenticated}
                    path="/account/details"
                    >
                    <AccountPage
                        content={AccountPersonalDetails}
                    />
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