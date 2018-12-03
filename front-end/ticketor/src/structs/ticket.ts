import Entity from './entity'

export default class Ticket extends Entity {
  title: string;
  priority: number;
  comments: Array<Object>;
  done: boolean;

  constructor(id : string, title : string, description : string, priority : number, comments : Array<Object>, done : boolean) {
    super(id, description, 'ticket');
    this.title = title;
    this.priority = priority;
    this.comments = comments;
    this.done = done;
  }

  static PriorityColor(num : Number) {
    let color = "";
    switch (num) {
      case 0:
      color = "rgb(40, 6, 71)";
      break;
      case 1:
      color = "yellow";
      break;
      case 2:
      color = "red";
      break;
    }
    return color;
  }

  priorityColor() : string {
    let color = "";
      switch (this.priority) {
        case 0:
        color = "rgb(70, 36, 101)";
        break;
        case 1:
        color = "yellow";
        break;
        case 2:
        color = "red";
        break;
      }
      return color;
  }

  exportData() : object {
    return {
      id: this.id,
      value: this.value,
      priority: this.priority,
      comments: this.comments,
      done: this.done
    }
  }

}
