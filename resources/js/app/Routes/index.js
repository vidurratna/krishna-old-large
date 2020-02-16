import React from 'react'
import { Switch, Route,Redirect } from 'react-router'
import Register from '../Containers/Auth/Register'
import Account from '../Containers/Auth/Account'
import Test from '../Containers/Admin/Test'
import { WithContext } from '../Containers'

export default function Routes() {
    return (
        <Switch>
            <Route exact path="/register" >
                <Register/>
            </Route>
            <Route exact path="/login" >
                Login
            </Route>
            <UserRoutes exact path="/account" >
                <Account/>
            </UserRoutes>
            <Route exact path="/pic" >
                <Test/>
            </Route>
            <AdminRoute path="/admin">
                Test
            </AdminRoute>
            <Route>
                Home page ywal
            </Route>
            
        </Switch>
    )
}

function PrivateRoute({ children, ...rest }) {
    return (
      <Route
        {...rest}
        render={({ location }) =>
          rest.user !== null ? (
            children
          ) : (
            <Redirect
              to={{
                pathname: "/login",
                state: { from: location }
              }}
            />
          )
        }
      />
    );
  }

  function ProtectedRoute({ children, ...rest }) {

    return (
      <Route
        {...rest}
        render={({ location }) =>
          rest.level <= 60 ? (
            children
          ) : (
            <Redirect
              to={{
                pathname: "/login",
                state: { from: location }
              }}
            />
          )
        }
      />
    );
  }

 const UserRoutes = WithContext(PrivateRoute)
 const AdminRoute = WithContext(ProtectedRoute)
  
