import Model from "@/models/Model";

export default class User extends Model{
    id?: string
    name?: string
    email?: string


    constructor() {
        super();
    }

    public static toString(): string {
        return 'User';
    }
}