package candy_vending_machine;

/**
 *
 * @author ccronk
 */
public class Candy implements Cloneable{
    
//--------------PROPERTIES-------------- 
    private String name = "";
    public String getName(){ return name; }
    public void setName(String newName) { name = newName; }
    
    private double price;
    public double getPrice(){ return price; }
    public void setPrice(double newPrice) { price = newPrice; }
     
//--------------CONSTRUCTORS--------------    
    //Default Constructor
    public Candy(){}
    
    //Full constructor
    public Candy(String newName, double newPrice){
        name = newName;
        price = newPrice;
    }    
    
//--------------METHODS--------------   
    /**
     * Custom equals method for quick comparisons between Candy instances.
     * @param candy the Candy to compare to
     * @return boolean, true if the candies have the same name and price
     */
    public boolean equals(Candy candy){
        if(this.getName().equals(candy.getName()) && this.getPrice() == candy.getPrice()){
            return true;
        }
        else{
            return false;
        }
    }
    
    //Clone
    @Override
    public Candy clone() throws CloneNotSupportedException{
        return (Candy) super.clone();
    }
}
