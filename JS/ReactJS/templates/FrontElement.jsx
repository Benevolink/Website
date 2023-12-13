
class FrontElement extends React.Component{
    constructor(props){
        super(props);
        //Permet de supprimer le fond sombre derrière également
        this.state = {
            id : "FrontElement",
            class : "FrontElement"
        };
    }
    
    render(){
        return(
        <div {...this.props}>
            <LeaveCross onClick={this.props.onDelete}/>
        </div>
        )
    }
}