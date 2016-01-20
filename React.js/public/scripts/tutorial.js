var CommentBox = React.createClass({
  render: function() {
    return (
      <div className="CommentBox">
        I am a CommentBox.
      </div>
    );
  }
});
ReactDOM.render(
  <CommentBox />,
  document.getElementById('conent')
);
