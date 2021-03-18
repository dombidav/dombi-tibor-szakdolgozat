export default abstract class Model {
    protected static modelName: string;

    public static All(): void{
        console.log(`All func of ${this.toString()}`)
    }

    public static Find(id: string|number): void{
        console.log(`Find func of ${this.toString()}`)
    }

    public static toString(): string{
        throw new Error('Model name was not overwritten in this class')
    }
}