import styled from  'styled-components';

import { Link } from 'react-router-dom';
import { device } from '../../../constants';



export const Page = styled.div`
    display: grid;
    grid-template-columns: ${props => props.left ? "2fr 1fr" : "1fr 2fr"};

    & .lazy-load-image-background {
        
        min-height: 100vh;
        height: 100vh;

        & img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }

    @media ${device.laptop} {
        grid-template-columns: ${props => props.left ? "4fr 1fr" : "1fr 4fr"};
    }

    @media ${device.tablet} {
        display: block;

        & img, .lazy-load-image-background {
            display: none !important;
        }
    }
`


export const Block = styled.div`
    background: #f7f7f7;
    ${props => props.left ? "border-right: 20px #e6ba81 solid;" : "border-left: 20px #e6ba81 solid;"}
    box-shadow: 5px 0px 14px 0px #000;
    display: grid;
    grid-template-columns: 3fr 2fr;
    padding: 135px;

    @media ${device.laptopL} {
        padding: 80px;
    }

    @media ${device.laptop} {
        padding: 60px;
    }

    @media ${device.tablet} {
        grid-template-columns: 1fr;
        padding: 30px;
        min-height: 100vh;
        box-shadow: none;
        border-left: none;
    }
`

export const Form = styled.div`
    margin: auto 15px;
`

export const Title = styled.h2`
    margin: 0;
    text-transform: uppercase;
    font-weight: 400;
    font-weight: 400;
    font-size: 36px;
`


export const SubTitle = styled.h5`
    margin: 0;
    color: #707070;
    font-weight: 300;
    padding-top: 40px;
    font-size: 20px;
`

export const CallToAction = styled.h5`
    margin: 0;
    color: #707070;
    font-weight: 300;
    padding-top: 40px;
    text-align: right;
    font-size: 20px;

    @media ${device.laptop} {
        font-size: 17px;
    }

    @media ${device.tablet} {
        font-size: 18px;
        text-align: center;
    }
`

export const SignUp = styled(Link)`
    padding-left: 5px;

    color: #41d2ff;

    transition: 0.3s;

    &:any-link{
        color: #41d2ff;
    }

    &:hover {
        color: #106e8c;
    }
`