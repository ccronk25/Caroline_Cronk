package candy_vending_machine;

/**
 *
 * @author ccronk
 */

// Candy Vending Machine Interface
public interface ICandyVendingMachine<Candy> {

    // Accepts the amount of money from the user
    void TakeMoney(double amount);

    // Returns the amount of money to the user
    void ReturnMoney(double amount);

    // Spits out an item based on the vending slot chosen by the user
    // Each vending machine should have SlotA, SlotB, and SlotC
    // Up to 5 items can be placed in each slot of the vending machine
    Candy VendItem(String slotCode);

    // Displays what kind of vending machine it is
    String GetMachineInfo();

    // Shows the item name and price for each Slot of the machine
    String DisplayContents();

}

