import { HTMLElement } from "../HTMLElement.mjs";
import { LeaveCross } from "./LeaveCross.mjs";

export class FrontElement extends React.Component{
    constructor(props,BackgroundId = false){
        super(props);

        //Permet de supprimer le fond sombre derrière également
        this.state = {
            id : "FrontElement"
        };

        
    }

    render(){
        <div class = "FrontElement" id = {this.props.id}>
            <LeaveCross />
        </div>
    }
}