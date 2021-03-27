import {Component, Input, OnInit, Output, EventEmitter} from '@angular/core';
import {UserModel} from '../../../models/user.model';

@Component({
  selector: 'app-public-settings',
  templateUrl: './public-settings.component.html',
  styleUrls: ['./public-settings.component.sass']
})
export class PublicSettingsComponent implements OnInit {

  @Input() public user: UserModel
  @Output() public userChange = new EventEmitter<UserModel>()

  constructor() { }

  ngOnInit(): void {
  }

}
