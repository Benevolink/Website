import React from "react";
import { FrontElement } from "./FrontElement.jsx";
import { ReactDOM } from "./ReactImport";

export class PopUp extends React.Component {
  constructor(props) {
    super(props);
    this.state = {
      showElements: true,
    };
  }

  handleDelete() {
    this.setState({
      showElements: false,
    });
  }

  render() {
    return (
      <div>
        {this.state.showElements && (
          <FrontElement onDelete={() => this.handleDelete()} />
        )}
      </div>
    );
  }
}
