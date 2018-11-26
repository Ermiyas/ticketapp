export default abstract class Entity {
  id: string;
  value: any;
  type: string;

  constructor(id : string, value : any, type : string) {
    this.id = id;
    this.value = value;
    this.type = type;
  }
}