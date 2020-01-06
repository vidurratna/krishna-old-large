import { SIGN_IN } from '../actionTypes'

const initState = {
    isAuthenticated: false,
    token: "",
    user: [],
}

const Authenticate = (state = initState, action) => {
    switch (action.type) {
        case SIGN_IN:
            return {
                ...state,
                isAuthenticated: true,
                token: action.value.token,
                user: action.value.user,
            }
    default:
        return state
    }
}

export default Authenticate