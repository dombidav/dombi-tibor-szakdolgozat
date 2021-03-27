import { NgModule } from '@angular/core';
import { BrowserModule } from '@angular/platform-browser';
import { HttpClientModule } from '@angular/common/http';

import { AppRoutingModule } from './app-routing.module';
import { AppComponent } from './app.component';
import { HomeComponent } from './pages/home/home.component';
import { SidebarComponent } from './components/sidebar/sidebar.component';
import { TopnavComponent } from './components/topnav/topnav.component';
import { FooterComponent } from './components/footer/footer.component';
import { BreadcrumbComponent } from './components/breadcrumb/breadcrumb.component';
import { LoginComponent } from './pages/login/login.component';
import { RegisterComponent } from './pages/register/register.component';

import {FormsModule} from '@angular/forms';
import {ProfileComponent} from './pages/profile/profile.component';
import {authInterceptorProviders} from './helpers/auth.interceptor';
import {AuthGuard} from './guards/auth-guard.service';
import { NotificationItemComponent } from './components/notification/notification-item/notification-item.component';
import {DatePipe} from '@angular/common';
import { ScriptLoaderComponent } from './helpers/script-loader/script-loader.component';
import { SettingsPageComponent } from './pages/settings-page/settings-page.component';
import {TabViewModule} from 'primeng/tabview';
import { PublicSettingsComponent } from './components/settings/public-settings/public-settings.component';
import { PrivateSettingsComponent } from './components/settings/private-settings/private-settings.component';
import { PasswordSettingsComponent } from './components/settings/password-settings/password-settings.component';


@NgModule({
  declarations: [
    AppComponent,
    HomeComponent,
    SidebarComponent,
    TopnavComponent,
    FooterComponent,
    BreadcrumbComponent,
    LoginComponent,
    RegisterComponent,
    ProfileComponent,
    NotificationItemComponent,
    ScriptLoaderComponent,
    SettingsPageComponent,
    PublicSettingsComponent,
    PrivateSettingsComponent,
    PasswordSettingsComponent
  ],
  imports: [
    BrowserModule,
    FormsModule,
    HttpClientModule,
    AppRoutingModule,
    TabViewModule
  ],
  providers: [authInterceptorProviders, AuthGuard, DatePipe],
  bootstrap: [AppComponent]
})
export class AppModule { }
