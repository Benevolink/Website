
class LeaveCross extends React.Component{
    constructor(props){
        super(props);
        this.state = {
            class : "croix_boite"
        };
    }
    render(){
        return(
        <img class = {this.props.class} src={abs_path("media/img/croix.jpg")}/>
        )
    }

}