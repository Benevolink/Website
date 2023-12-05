import { LeaveCross } from "./LeaveCross.jsx";
import {React,ReactDOM} from "./ReactImport";

export class FrontElement extends React.Component{
    constructor(props){
        super(props);
        
        //Permet de supprimer le fond sombre derrière également
        this.state = {
            id : "FrontElement",
            class : "FrontElement"
        };

        
    }
    
    render(){
        <div {...this.props}>
            <LeaveCross onClick={this.props.onDelete}/>
        </div>
    }
}