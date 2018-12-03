import Entity from './entity'

export default class Comment extends Entity {
  owner: string;
  timestamp: number;
  constructor(id : string, text : string, owner : string, timestamp : number) {
    super(id, text, "comment");
    this.owner = owner;
    this.timestamp = timestamp;
  }

  displayDate() :string {
    let date = new Date(this.timestamp);
    return ` ${date.getHours()}:${date.getMinutes()} ${date.getDate()}.${date.getMonth()}`;
  }
}