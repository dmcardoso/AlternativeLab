import React, {Component} from "react";

const initialState = {
    redirect: false,
    load: true,
};

class PrivateRouter extends Component {
    state = {...initialState};

    asyncall = async (stallTime = 3000) => {
        await new Promise(resolve => setTimeout(resolve, stallTime));
    };

    fake = async () => {

        await this.asyncall(); // stalls for the default 3 seconds
    };

    render() {
        console.log('render');
        const {component: Component, ...props} = this.props;

        props.load = this.state.load;

        if (this.state.load === true) {
            console.log('load');
            this.fake().then(res => {
                this.setState({...this.state, load: false});
            });
        }

        return (
            <Component {...props}/>
        );
    }
}

export default PrivateRouter;
