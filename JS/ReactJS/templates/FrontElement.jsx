import { LeaveCross } from "./LeaveCross.jsx";
import {React,ReactDOM} from "./ReactImport";

export class FrontElement extends React.Component{
    constructor(props){
        super(props);
        
        //Permet de supprimer le fond sombre derrière également
        this.state = {
            id : "FrontElement"
        };

        
    }
    
    render(){
        <div class = "FrontElement" id = {this.props.id}>
            <LeaveCross onClick={this.props.onDelete}/>
        </div>
    }
}