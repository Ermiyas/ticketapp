import Entity from './entity'

export default class Divider extends Entity {
  constructor(id : string, value : string, ) {
    super(id, value, 'ticket-divider');
  }
}