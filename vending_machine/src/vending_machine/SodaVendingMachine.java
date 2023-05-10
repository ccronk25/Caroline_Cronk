package vending_machine;

import java.util.LinkedList;
import java.util.Queue;
import java.util.Scanner;
import java.util.logging.Level;
import java.util.logging.Logger;

/**
 *
 * @author ccronk
 */

public class SodaVendingMachine implements IVendingMachine<Soda>{
    
//--------------PROPERTIES-------------- 
    public static final int MAX_SLOT_SIZE = 5;
    
    private double money;
    public double getMoney(){return money;}
    public void setMoney(double newMoney){money = newMoney;}
    
    private double price;
    public double getPrice(){return price;}
    public void setPrice(double newPrice){price = newPrice;}
    
    private Queue<Soda> slotA;
    private Queue<Soda> slotB;
    private Queue<Soda> slotC;

//--------------CONSTRUCTORS--------------    
    //Constructor
    public SodaVendingMachine(){
        slotA = new LinkedList();
        slotB = new LinkedList();
        slotC = new LinkedList();
        money = 0;
        price = 0;
    }
    
    
//--------------METHODS-------------- 
    
    /**
     * Determines which queue to add to based on slot code and adds Soda instances 
     * to a vending machine slot.
     * @param slotCode "A", "B", or "C", representing which slot the soda should go in
     * @param soda the Soda instance to be added
     * @param amount number of Soda instances to add
     */
    public void addToSlot(String slotCode, Soda soda, int amount) {
        
        try {
            if(slotCode.equals("A")){ 
                checkSlot(slotA, soda, amount);  
            }
            else if(slotCode.equals("B")){
                checkSlot(slotB, soda, amount);
            }
            else{
                checkSlot(slotC, soda, amount);
            }
        } catch (CloneNotSupportedException ex) {
                    Logger.getLogger(SodaVendingMachine.class.getName()).log(Level.SEVERE, null, ex);
        }    
    }
    
    /**
     * Checks if adding soda to a slot is possible. If it is, it clones the soda
     * and adds it to the slot, capping the size of the slot queue at 5.
     * @param queue the queue to add the Soda to
     * @param soda the Soda instance to be added. Must match the soda currently in that slot.
     * @param amount number of times the Soda should be cloned and added.
     * @throws CloneNotSupportedException 
     */
    public void checkSlot(Queue<Soda> queue, Soda soda, int amount) throws CloneNotSupportedException {
        Soda queueSoda;
        if (queue.isEmpty()){
            queueSoda = soda; //if it's empty, make the slot match the new soda
        }
        else{
            queueSoda = queue.peek(); //otherwise, check
        }

        if(queueSoda.matches(soda)){
            for(int ii = 0; ii < amount && queue.size() < MAX_SLOT_SIZE; ii++){
                queue.add(soda.clone());
            }
        } else{
            System.out.println("Error: Unable to add " + soda.getName() + ", as it does not match the soda in this slot.");
        }       
    }
    
    /**
     * Checks if a slot queue is empty.
     * @param slotCode "A", "B", or "C", each corresponds to a queue
     * @return 
     */
    public boolean hasItems(String slotCode){
        //figure out which queue to check
        Queue queue;
        if(slotCode.equals("A")){ 
           queue = slotA;
        }
        else if(slotCode.equals("B")){
            queue = slotB;
        }
        else{
             queue = slotC;
        } 
        
        //check if it's empty
        if(queue.isEmpty()){
            return false;
        }
        else{
            return true;
        }
    }
    
    public void selectSlot(){
        Scanner input = new Scanner(System.in);
        String userInput = "";
        
        while (!userInput.equals("Q")){ //based on chapter 6 stacks example
            System.out.print(this.DisplayContents()); 
            System.out.println("\nEnter a slot code to select a soda or 'q' to quit:");

            userInput = input.nextLine().trim().toUpperCase();
            
            switch (userInput) {
                case "A":
                    if(this.hasItems(userInput)){
                        this.selectItem(userInput);
                    }
                    else{
                        System.out.print("Slot A is empty.");
                    }
                    break;
                case "B":
                    if(this.hasItems(userInput)){
                        this.selectItem(userInput);
                    }
                    else{
                        System.out.print("Slot B is empty.");
                    }
                    break;
                case "C":
                    if(this.hasItems(userInput)){
                        this.selectItem(userInput);
                    }
                    else{
                        System.out.print("Slot C is empty.");
                    }
                    break;
                case "Q":
                    break;
                default:
                    System.out.print("Invalid input.");
                    break;  
            }
        }
        
    }    
    
    /**
     * Selects a vending machine slot to pull soda from.
     * @param slotCode "A", "B", or "C", each corresponds to a queue
     */
    public void selectItem(String slotCode) {
        //figure out the price of the selected soda
        if(slotCode.equals("A")){ 
           setPrice(slotA.peek().getPrice());
        }
        else if(slotCode.equals("B")){
           setPrice(slotB.peek().getPrice());
        }
        else{
            setPrice(slotC.peek().getPrice());
        } 
        
        Scanner input = new Scanner(System.in);
        String userInput = "";
        
        //ask for money
        System.out.println("Input a dollar amount:");
        while(!sufficientFunds() && !userInput.equals("Q")){
            userInput = input.nextLine().trim().toUpperCase();
            
            try { //try to turn user input into a double
                double funds = Double.parseDouble(userInput); //source: https://stackoverflow.com/questions/3543729/how-to-check-that-a-string-is-parseable-to-a-double
                TakeMoney(funds);
                if(!sufficientFunds()){
                    System.out.println("Insufficient funds. Enter more money or 'q' to cancel transaction:");
                }
            } //if you can't (ie there's characters), check if it was q or invalid
            catch(NumberFormatException e) {
                if(userInput.equals("Q")){
                    System.out.print("Transaction canceled. ");
                    ReturnMoney(getMoney());
                }
                else{
                    System.out.println("Invalid input. Enter dollar amount or 'q' to cancel transaction:");
                }
            }
        } 
           
        if(sufficientFunds()){ //while loop is broken, checks if it's because there's enough funds (not because it was canceled)
            Soda soda = VendItem(slotCode);
            System.out.println("You recieve 1 " + soda.getName() + " ($" + soda.getPrice() + ").");
            ReturnMoney(money-price);
        }
    }
    
    /**
     * Compares user input stored in money variable to price of current soda.
     * @return boolean, true if money is greater than or equal to price.
     */
    public boolean sufficientFunds(){
        if(price <= money && money != 0){ //was counting as sufficient funds when both were 0
            return true;
        }
        else{
            return false;
        }
    }
    
    // Accepts the amount of money from the user
    @Override
    public void TakeMoney(double amount) {
        setMoney(getMoney() + amount);
    }
    

    // Returns the amount of money to the user (and resets transaction variables)
    @Override
    public void ReturnMoney(double amount) {
        if(amount != 0){ //in cases where the change is $0, don't print
            System.out.print("Your change is: $");
            System.out.printf ("%.2f", amount); //https://stackoverflow.com/questions/7197078/printf-f-with-only-2-numbers-after-the-decimal-point
            System.out.print("\n"); //formatting for clean output
        }    
        setMoney(0);
        setPrice(0);
    }

    // Spits out an item based on the vending slot chosen by the user
    @Override
    public Soda VendItem(String slotCode) {
        Soda soda = null;
        
        if(slotCode.equals("A")){ 
           soda = slotA.poll(); //or .remove()
        }
        else if(slotCode.equals("B")){
            soda = slotB.poll();
        }
        else{
            soda = slotC.poll();
        } 
        
        return soda;
    }
    

    // Displays what kind of vending machine it is
    @Override
    public String GetMachineInfo() {
        return "Soda Vending Machine";
    }

    // Shows the item name and price for each Slot of the machine
    @Override
    public String DisplayContents() {
        StringBuilder contents = new StringBuilder();
        
        contents.append("\n").append(GetMachineInfo()).append(" Options: \n");
        
        contents.append("Slot A: ");
        if(!slotA.isEmpty()){
            contents.append(slotA.peek().getName()).append(" $");
            contents.append(slotA.peek().getPrice()).append(" (");
            contents.append(slotA.size()).append(")\n");
        }
        else{
            contents.append("This slot is empty\n");
        }
        
        contents.append("Slot B: ");
        if(!slotB.isEmpty()){
            contents.append(slotB.peek().getName()).append(" $");
            contents.append(slotB.peek().getPrice()).append(" (");
            contents.append(slotB.size()).append(")\n");
        }
        else{
            contents.append("This slot is empty\n");
        }
        
        contents.append("Slot C: ");
        if(!slotC.isEmpty()){
            contents.append(slotC.peek().getName()).append(" $");
            contents.append(slotC.peek().getPrice()).append(" (");
            contents.append(slotC.size()).append(")\n");
        }
        else{
            contents.append("This slot is empty\n");
        }
 
        return contents.toString();
    }
    
}
