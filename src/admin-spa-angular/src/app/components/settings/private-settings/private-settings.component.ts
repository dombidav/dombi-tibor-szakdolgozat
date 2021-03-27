import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {UserModel} from '../../../models/user.model';

@Component({
  selector: 'app-private-settings',
  templateUrl: './private-settings.component.html',
  styleUrls: ['./private-settings.component.sass']
})
export class PrivateSettingsComponent implements OnInit {

  @Input() public user: UserModel
  @Output() public userChange = new EventEmitter<UserModel>()

  constructor() { }

  ngOnInit(): void {
  }

}
