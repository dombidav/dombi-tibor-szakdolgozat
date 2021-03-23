import {Component, Input, OnInit} from '@angular/core';

@Component({
  selector: 'app-script-loader',
  templateUrl: './script-loader.component.html',
  styleUrls: ['./script-loader.component.sass']
})
export class ScriptLoaderComponent implements OnInit {

  @Input() src: string
  @Input() defer: boolean = false
  @Input() head: boolean = false

  constructor() { }

  ngOnInit(): void {
    let node = document.createElement('script')
    node.src = this.src
    node.type = 'text/javascript'
    node.defer = this.defer
    if(this.head)
      document.getElementsByTagName('head')[0].appendChild(node)
    else
      document.getElementById('after-angular').appendChild(node)
  }

}
