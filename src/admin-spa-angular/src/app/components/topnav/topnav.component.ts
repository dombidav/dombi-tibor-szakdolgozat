import {Component, Injectable, OnInit} from '@angular/core';
import {TokenStorageService} from '../../services/token-storage.service';
import {UserNotification} from '../../models/UserNotification.model';
import {UserNotificationType} from '../../helpers/UserNotificationType.enum';
import {AppRoutingModule} from '../../app-routing.module';

@Component({
  selector: 'app-topnav',
  templateUrl: './topnav.component.html',
  styleUrls: ['./topnav.component.sass']
})
@Injectable({
  providedIn: 'root'
})
export class TopnavComponent implements OnInit {

  public userName: string
  notifications: UserNotification[] = []

  constructor(private tokenService: TokenStorageService, private router: AppRoutingModule) {
    this.userName = tokenService.getUser().name
  }

  signOut(){
    this.tokenService.signOut();
  }

  ngOnInit(): void {
    this.notifications.push(new UserNotification(
      'Lorem Ipsum',
      'Lorem ipsum dolores, Lorem ipsum dolores, Lorem ipsum dolores, Lorem ipsum dolores.',
      new Date(Date.parse('2021.03.22 20:38:00')),
      UserNotificationType.Information
    ))
    this.notifications.push(new UserNotification(
      'Lorem Ipsum 2',
      'Lorem ipsum dolores, Lorem ipsum dolores, Lorem ipsum dolores, Lorem ipsum dolores.',
      new Date(Date.parse('2021.03.22 17:11:00')),
      UserNotificationType.Warning
    ))
    this.notifications.push(new UserNotification(
      'Lorem Ipsum 3',
      'Lorem ipsum dolores, Lorem ipsum dolores, Lorem ipsum dolores, Lorem ipsum dolores.',
      new Date(Date.parse('2021.03.11 16:00:00')),
      UserNotificationType.Error
    ))
  }

}
