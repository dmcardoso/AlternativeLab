import React from "react";

function HighOrder(props) {
    console.log(props, 'high');
    if (props.load) {
        return (
            <div>loading...</div>
        )
    }

    return (
        <div>
            {props.children}
        </div>
    );
}

export default HighOrder;
