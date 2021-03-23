import { Component, OnInit } from '@angular/core';
import {TokenStorageService} from '../../services/token-storage.service';
import {UserModel} from '../../models/user.model';

@Component({
  selector: 'app-settings-page',
  templateUrl: './settings-page.component.html',
  styleUrls: ['./settings-page.component.sass']
})
export class SettingsPageComponent implements OnInit {

  public user: UserModel

  constructor(private token: TokenStorageService) {
    this.user = token.getUser()
  }

  ngOnInit(): void {
  }

}
