export class UserModel {
  id?: string
  name?: string
  email: string
  createdAt: Date
  // Functions
  exists(): boolean{
    return this.id?.length > 0
  }
}
