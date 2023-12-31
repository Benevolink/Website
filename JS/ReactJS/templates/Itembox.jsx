class Itembox extends React.Component{
    constructor(props){
        super(props);
        //Permet de supprimer le fond sombre derrière également
        this.state = {
            class : "Itembox"
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