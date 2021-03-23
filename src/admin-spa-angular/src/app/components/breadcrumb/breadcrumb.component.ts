import {Component, Input, OnInit} from '@angular/core';

@Component({
  selector: 'app-breadcrumb',
  templateUrl: './breadcrumb.component.html',
  styleUrls: ['./breadcrumb.component.sass']
})
export class BreadcrumbComponent implements OnInit {
  @Input() items?: any

  public objectItems: {url: string, title: string}[] = []

  constructor() { }

  ngOnInit(): void {
    Object.keys(this.items).forEach(key => {
      this.objectItems.push({
        url: key,
        title: this.items[key]
      })
    })
  }

}
