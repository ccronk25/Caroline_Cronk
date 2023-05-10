package vending_machine;

/**
 * Character represents a Star Wars character, with the ability to fight and
 * print a taunt phrase. Force has been converted to an int so the force class
 * doesn't need to be imported.
 * @author ccronk
 */
public class StarWarsCharacter implements Cloneable, IVendable<StarWarsCharacter>{
    
//PROPERTIES    
    private String firstName;
    public String getFirstName() { return firstName; }
    public void setFirstName(String name) { firstName = name; }
    
    private String lastName;
    public String getLastName() { return lastName; }
    public void setLastName(String name) { lastName = name; }
    
    private int age;
    public int getAge() { return age; }
    public void setAge(int newAge) { age = newAge; }
    
    private char gender;
    public char getGender() { return gender; }
    public void setGender(char newGender) { gender = newGender; }
    
    private String tauntPhrase;
    public String getTaunt() { return tauntPhrase; }
    public void setTaunt(String newTaunt) { tauntPhrase = newTaunt; }
    
    private int force;
    public int getForce() { return force; }
    public void setForce(int newForce) { force = newForce; }
    
    private double price;
    @Override
    public double getPrice() { return price; }
    public void setPrice(double newPrice) { price = newPrice; }
    
//CONSTRUCTORS    
    /**
     * Default constructor.
     */
    public StarWarsCharacter(){}
    
    /**
     * Constructs character object with first and last name.
     * @param newFirstName the character's first name
     * @param newLastName the character's last name
     */
    public StarWarsCharacter(String newFirstName, String newLastName){
        setFirstName(newFirstName);
        setLastName(newLastName);
    }
    
    public StarWarsCharacter(String newFirstName, String newLastName, double newPrice){
        setFirstName(newFirstName);
        setLastName(newLastName);
        setPrice(newPrice);
    }
    
    /**
     * Constructs character object with first and last name and a Force object.
     * @param newFirstName the character's first name
     * @param newLastName the character's last name
     * @param newForce an existing Force object
     * 
     */
    public StarWarsCharacter(String newFirstName, String newLastName, int newForce){
        setFirstName(newFirstName);
        setLastName(newLastName);
        setForce(newForce);
    }
    
    /**
     * Constructs a character with all parameters.
     * @param newFirstName the character's first name
     * @param newLastName the character's last name
     * @param newForce an existing Force object
     * @param newAge their age
     * @param newGender their gender
     * @param newTaunt their taunt phrase
     */
    public StarWarsCharacter(String newFirstName, String newLastName, int newForce, int newAge, char newGender, String newTaunt){
        setFirstName(newFirstName);
        setLastName(newLastName);
        setForce(newForce);
        setAge(newAge);
        setGender(newGender);
        setTaunt(newTaunt);
    }
     
//METHODS
    /**
     * Prints the character's taunt variable to the console.
     */
    public void taunt(){
        System.out.println("\"" + tauntPhrase + "\"");
    }
    
    /**
     * Compares the strength and side of two character's force objects, then 
     * states the winner or declares a tie.
     * @param character1 The first character
     * @param character2 another character
     */
    public static void fight(StarWarsCharacter character1, StarWarsCharacter character2){
        int force1 = character1.force; //learned this from class lecture
        int force2 = character2.force;
        
        //Check if the strength of the characters are equal
        if(force1 == force2){
                System.out.println("After an intense battle, " + character1.getName() + " and " + character2.getName() + " were proven to be evenly matched in their strength in the Force.");
        }
        else{
            //declare winner and loser variables- I needed to declare them to use them outside the if statement anyway, so I just saved myself an else clause
            StarWarsCharacter winner = character1;
            StarWarsCharacter loser = character2;
                
            //compare the strength of the characters
            if(force1 < force2){
                winner = character2;
                loser = character1;
            }
            
            System.out.print(winner.getName() + " fights " + loser.getName() + " and wins! " + winner.getName() + " gloats: ");
            winner.taunt();
        }
    }
    
    /**
     * Clones the Character object it is called on.
     * @return a new Character object
     * @throws CloneNotSupportedException 
     */
    @Override
    public StarWarsCharacter clone() throws CloneNotSupportedException{
        return (StarWarsCharacter) super.clone();
    }
    
    /**
     * An accessor method that returns the full name, accounting for characters without last names
     * @return a string with the character's full name
     */
    @Override
    public String getName(){
        String name = firstName;
        if(lastName != null){ //check if there is a last name
            name += " " + lastName;
        }
        return name;
    }

    @Override
    public boolean matches(StarWarsCharacter character) {
        if(this.getName().equals(character.getName()) && this.getPrice() == character.getPrice()){
            return true;
        }
        else{
            return false;
        }
    }

}
