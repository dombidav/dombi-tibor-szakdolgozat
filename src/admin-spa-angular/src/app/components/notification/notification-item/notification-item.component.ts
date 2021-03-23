import {Component, Injectable, Input, OnInit} from '@angular/core';
import {UserNotification} from '../../../models/UserNotification.model';
import {DatePipe} from '@angular/common';

@Component({
  selector: 'app-notification-item',
  templateUrl: './notification-item.component.html',
  styleUrls: ['./notification-item.component.sass']
})
@Injectable({
  providedIn: 'root'
})
export class NotificationItemComponent implements OnInit {

  @Input() notification: UserNotification
  dateText: string = '';

  constructor(public datePipe: DatePipe) { }

  ngOnInit(): void {
    let minutesAgo = Math.ceil((Date.now() - (this.notification.created_at).getTime()) / 60_000)
    this.dateText =
      minutesAgo < 60
        ? `${minutesAgo} minutes ago`
        : (this.dateText = minutesAgo < 1440
          ? `${Math.floor(minutesAgo / 60)} hours ago`
          : `${Math.floor(minutesAgo / 1440)} days ago`
      );
  }

}
