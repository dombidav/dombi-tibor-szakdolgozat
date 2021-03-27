import { Component, OnInit } from '@angular/core';
import {TokenStorageService} from '../../services/token-storage.service';
import {UserModel} from '../../models/user.model';
import {TabViewModule} from 'primeng/tabview';

@Component({
  selector: 'app-settings-page',
  templateUrl: './settings-page.component.html',
  styleUrls: ['./settings-page.component.sass']
})
export class SettingsPageComponent implements OnInit {

  index = 0; //Used by TabViewModule
  public user: UserModel

  constructor(private token: TokenStorageService) {
    this.user = token.getUser()
  }

  ngOnInit(): void {
  }

}
