import {Component, EventEmitter, Input, OnInit, Output} from '@angular/core';
import {UserModel} from '../../../models/user.model';

@Component({
  selector: 'app-password-settings',
  templateUrl: './password-settings.component.html',
  styleUrls: ['./password-settings.component.sass']
})
export class PasswordSettingsComponent implements OnInit {

  @Input() public user: UserModel
  @Output() public userChange = new EventEmitter<UserModel>()

  constructor() { }

  ngOnInit(): void {
  }

}
