import { HTMLElement } from "../HTMLElement.mjs";

export class LeaveCross extends React.Component{
    constructor(props){
        super(props);
    }
    render(){
        <img class = {abs_path("media/img/croix.jpg")} id="croix_boite" onClick={hancleClick()}/>
    }

}