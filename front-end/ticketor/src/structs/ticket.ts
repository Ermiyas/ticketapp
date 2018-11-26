import Entity from './entity'

export default class Ticket extends Entity {
  title: string;
  priority: number;
  comments: Array<Object>;

  constructor(id : string, title : string, description : string, priority : number, comments : Array<Object>) {
    super(id, description, 'ticket');
    this.title = title;
    this.priority = priority;
    this.comments = comments;
  }
}