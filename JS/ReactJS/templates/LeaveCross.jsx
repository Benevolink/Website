import {React,ReactDOM} from "./ReactImport";
export class LeaveCross extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            class : "croix_boite"
        };
    }
    render(){
        <img class = {abs_path("media/img/croix.jpg")}/>
    }

}