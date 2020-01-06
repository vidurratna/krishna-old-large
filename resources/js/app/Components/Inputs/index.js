import styled from  'styled-components';
import TextField from '@material-ui/core/TextField';

export const Input = styled(TextField)`
    & .MuiFilledInput-input {
            border-radius: 7px;
            padding: 30px 10px 25px 12px;
        }

    & .MuiInputLabel-filled{
        transform: translate(12px, 30px) scale(1.25);
    }

    & .MuiInputLabel-shrink{
        transform: translate(13px, -4px) scale(0.75);
    }

    & .MuiFormHelperText-root{
        padding: 10px 0px;
    }

    margin: 10px 0px;
    background: #ffffff;
`;
