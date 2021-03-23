import {UserNotificationType} from '../helpers/UserNotificationType.enum';

export class UserNotification {

  id?: string
  title:string = 'NOTIFICATION'
  description: string = ''
  created_at: Date = new Date(Date.now())
  Type: UserNotificationType = UserNotificationType.Information
  action: string = null

  exists(): boolean{
    return this.id?.length > 0
  }

  constructor(title: string, description: string, created_at: Date = null, Type: UserNotificationType = UserNotificationType.Information, action: string = null) {
    this.title = title;
    this.description = description;
    this.created_at = created_at ?? new Date(Date.now());
    this.Type = Type;
    this.action = action;
  }
}
