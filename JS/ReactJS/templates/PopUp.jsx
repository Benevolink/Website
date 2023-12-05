import { FrontElement } from "./FrontElement.jsx";
import {React,ReactDOM} from "./ReactImport";
export class PopUp extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            showElements: true
        };
    }
    handleDelete(){
        this.state = {
            showElements : false
        }
    }
    render(){
        {
            this.state.showElements &&
            <div>
                <FrontElement onDelete={this.handleDelete()}/>
            </div>
        }
        
    }
}